<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use App\Models\Gateway;
use App\Models\Order;
use App\Models\Orderitem;
use App\Models\Prompt;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Traits\Uploader;
use Session;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CheckoutController extends Controller
{

    use Uploader;

    private function buynow_cart($prompt)
    {
        return [
            [
                'id' => $prompt->id,
                'price' => $prompt->price,
                'title' => $prompt->title,
                'slug' => $prompt->slug,
                'user' => $prompt->user_id,
                'model' => $prompt->promptmodel->title,
                'preview' => $prompt->preview ?? json_decode($prompt->meta)->preview ?? null,
            ]
        ];
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $carts = $request->session()->get('cart', []);
        if ($request->filled('prompt')) {
            $prompt = Prompt::where('status', 1)->with('promptmodel:id,title')->findOrFail($request->prompt);
            $alreadyPurchased = DB::table('orderitems')
                ->join('users', 'orderitems.user_id', '=', 'users.id')
                ->join('prompts', 'orderitems.prompt_id', '=', 'prompts.id')
                ->join('orders', 'orderitems.order_id', '=', 'orders.id')
                ->join('promptmodels', 'prompts.promptmodel_id', '=', 'promptmodels.id')
                ->selectRaw('prompts.*, users.name, users.avatar, users.username, promptmodels.title as model_title')
                ->where('orders.user_id', auth()->user()->id)
                ->where('prompts.id', $prompt->id)
                ->groupBy('prompts.id')
                ->orderBy('orders.created_at', 'desc')
                ->get();
            if (!$alreadyPurchased->isEmpty()) {
                return throw ValidationException::withMessages(['prompt' => 'You have already purchased this prompt']);
            }
            $carts = $this->buynow_cart($prompt);
        }
        if ($request->filled('collection')) {
            $alreadyPurchased = DB::table('orderitems')
                ->join('users', 'orderitems.user_id', '=', 'users.id')
                ->join('prompts', 'orderitems.prompt_id', '=', 'prompts.id')
                ->join('orders', 'orderitems.order_id', '=', 'orders.id')
                ->join('promptmodels', 'prompts.promptmodel_id', '=', 'promptmodels.id')
                ->selectRaw('prompts.*, users.name, users.avatar, users.username, promptmodels.title as model_title')
                ->where('orders.user_id', auth()->user()->id)
                ->groupBy('prompts.id')
                ->orderBy('orders.created_at', 'desc')
                ->pluck('prompts.id');

            $collection = Collection::where('status', 1)
                ->withCount(['prompts' => function ($query) use ($alreadyPurchased) {
                    $query->whereNotIn('id', $alreadyPurchased);
                }])
                ->findOrFail($request->collection);
            $promptPrice = Prompt::where('status', 1)
                ->whereNotIn('id', $alreadyPurchased)
                ->where('collection_id', $collection->id)
                ->with('promptmodel:id,title')
                ->sum('price');
            $newCollection = [
                'id' => $collection->id,
                'name' => $collection->name,
                'preview' => $collection->preview,
                'price' => $promptPrice,
                'prompts' => $collection->prompts_count,
                'isCollection' => true,
            ];
        }
        if (
            count($carts) == 0 &&
            !$request->filled('collection') &&
            !$request->filled('prompt')
        ) {
            return Inertia::location(route('user.cart.index'));
        }

        $user = auth()->user();
        $gateways = Gateway::where('status', 1)->select('id','name','currency','logo','charge','multiply','min_amount','max_amount','is_auto','image_accept','test_mode','status','phone_required','comment')->get();
        $tax      = get_option('tax');

        return Inertia::render('Frontend/Checkout/Index', [
            'carts' => $carts,
            'user' => $user,
            'gateways' => $gateways,
            'tax' => $tax,
            'promptId' => $request->prompt ?? null,
            'collection' => $newCollection ?? null,
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (empty($request->gateway_id)) {
            return back()->withErrors([
                'gateway_id' => __('Please select a payment gateway'),
            ])->onlyInput('gateway_id');
        }


        $carts = $request->session()->get('cart', []);

        if (
            count($carts) == 0 &&
            !$request->filled('collection') &&
            !$request->filled('prompt')
        ) {
            return Inertia::location(route('user.cart.index'));
        }
        if ($request->filled('prompt')) {
            $prompt = Prompt::where('status', 1)->with('promptmodel:id,title')->findOrFail($request->prompt);
            $carts = $this->buynow_cart($prompt);
        }
        if ($request->filled('collection')) {
            $alreadyPurchased = DB::table('orderitems')
                ->join('users', 'orderitems.user_id', '=', 'users.id')
                ->join('prompts', 'orderitems.prompt_id', '=', 'prompts.id')
                ->join('orders', 'orderitems.order_id', '=', 'orders.id')
                ->join('promptmodels', 'prompts.promptmodel_id', '=', 'promptmodels.id')
                ->selectRaw('prompts.*, users.name, users.avatar, users.username, promptmodels.title as model_title')
                ->where('orders.user_id', auth()->user()->id)
                ->groupBy('prompts.id')
                ->orderBy('orders.created_at', 'desc')
                ->pluck('prompts.id');
            $collection = Collection::where('status', 1)
                ->withCount(['prompts' => function ($query) use ($alreadyPurchased) {
                    $query->whereNotIn('id', $alreadyPurchased);
                }])
                ->findOrFail($request->collection);
            $prompts = Prompt::where('status', 1)
                ->whereNotIn('id', $alreadyPurchased)
                ->where('collection_id', $collection->id)
                ->with('promptmodel:id,title')
                ->get();
            $carts = [];
            foreach ($prompts as $prompt) {
                $cart = $this->buynow_cart($prompt);
                array_push($carts, $cart[0]);
            }
        }
        $tax      = get_option('tax', true);
        $gateway  = Gateway::where('status', 1)->findOrFail($request->gateway_id);


        $cart_total = 0;
        $items = [];


        foreach ($carts as $cart) {
            $cart_total = $cart_total + $cart['price'];
            array_push($items, array(
                'prompt_id' => $cart['id'],
                'amount' => $cart['price'],
                'user_id' => $cart['user']
            ));
        }

        $tax = $tax > 0 ? ($cart_total / 100) * $tax : 0;
        $total    = (float)$tax + $cart_total;

        $orderData['payable'] = $total * $gateway->multiply + $gateway->charge;
        $orderData['cart_total'] = $cart_total;
        $orderData['tax'] = $tax;
        $orderData['orders'] = $items;



        Session::put('order_data', $orderData);
        if ($gateway->is_auto == 0) {

            $request->validate([
                'manualPayment.comment' => ['required', 'string', 'max:500'],
                'manualPayment.image' => ['required', 'image', 'max:2048'], // 2MB
            ]);

            $payment_data['comment'] = $request->input('manualPayment.comment');
            $image = $this->saveFile($request, 'manualPayment.image');
            $payment_data['screenshot'] = $image;
            $payment_data['comment'] = $request->input('manualPayment.comment');
        }

        $payment_data['currency']   = $gateway->currency ?? 'USD';
        $payment_data['email']      = Auth::user()->email;
        $payment_data['name']       = Auth::user()->name;
        $payment_data['phone']      = $request->phone;
        $payment_data['billName']   = 'Order from - ' . env('APP_NAME');
        $payment_data['amount']     = $total;
        $payment_data['test_mode']  = $gateway->test_mode;
        $payment_data['charge']     = $gateway->charge ?? 0;
        $payment_data['pay_amount'] =  str_replace(',', '', number_format($orderData['payable']));
        $payment_data['getway_id']  = $gateway->id;

        $callback['success'] = url('/order/pay/success');
        $callback['fail']    = url('/order/pay/failed');
        Session::put('call_back', $callback);


        if (!empty($gateway->data)) {
            foreach (json_decode($gateway->data ?? '') ?? [] as $key => $info) {
                $payment_data[$key] = $info;
            };
        }

        return $gateway->namespace::make_payment($payment_data);
    }

    /**
     * check payment status hook
     *
     * @param   $status
     * @return \Illuminate\Http\Response
     */
    public function status($status)
    {
        abort_if(!Session::has('call_back') || !Session::has('order_data'), 404);

        return $status == 'success' ? $this->success() : $this->faild();
    }

     /**
     * execute payment if success status 
     *
     * @param   $status
     * @return \Illuminate\Http\Response
     */
    public function success()
    {
        abort_if(!Session::has('payment_info'), 404);

        $paymentInfo = Session::get('payment_info');

        Session::forget('payment_info');
        Session::forget('call_back');
        Session::forget('cart');


        $orderData     = Session::get('order_data');
        Session::forget('order_data');



        $tax      = get_option('tax');
        $tax      = $tax > 0 ? ($orderData['cart_total'] / 100) * $tax : 0;
        DB::transaction(function () use ($paymentInfo, $tax, $orderData) {
            $order = new Order;
            $order->user_id     = Auth::user()->id;
            $order->payment_id  = $paymentInfo['payment_id'];
            $order->user_id     = Auth::id();
            $order->gateway_id  = $paymentInfo['getway_id'];
            $order->amount      = $paymentInfo['amount'];
            $order->tax         = $tax;
            $order->status      = $paymentInfo['status'] ?? 0;

            if (isset($paymentInfo['meta'])) {
                $order->meta    = json_encode($paymentInfo['meta']);
            }
            $order->save();

            $order_items = [];

            foreach ($orderData['orders'] as $key => $row) {
                $arr['order_id'] = $order->id;
                $arr['amount'] = $row['amount'];
                $arr['prompt_id'] = $row['prompt_id'];
                $arr['user_id'] = $row['user_id'];

                array_push($order_items, $arr);
            }

            Orderitem::insert($order_items);
        });

        return redirect('/thank-you');
    }

     /**
     * execute payment if failed status 
     *
     * @param   $status
     * @return \Illuminate\Http\Response
     */
    public function faild()
    {
        Session::forget('payment_info');
        Session::forget('call_back');

        return redirect('/checkout')->withErrors([
            'gateway_id' => __('Oops! We encountered an issue processing your payment. Please check your payment details and retry.'),
        ])->onlyInput('gateway_id');
    }
    
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function thank_you()
    {
        return Inertia::render('Frontend/Checkout/ThankYou');
    }
}
