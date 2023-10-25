<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Creditlog;
use App\Models\Gateway;
use App\Models\Generatedimage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use App\Traits\Uploader;
use Illuminate\Support\Facades\DB;

class GenerateController extends Controller
{
    use Uploader;

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $gateways = Gateway::where('status', 1)->select('id','name','currency','logo','charge','multiply','min_amount','max_amount','is_auto','image_accept','test_mode','status','phone_required','comment')->get();
        $credit_fee = get_option('per_credit_fee');
        $generatedImages = Generatedimage::query()
            ->where('user_id', auth()->id())->latest()->paginate(10);

        if (count($generatedImages->items()) > 0) {
            $mapImages = collect($generatedImages->items())->map(function ($item) {
                return json_decode($item->images, true);
            });
            $images = array_merge_recursive(...$mapImages);
        }
        return Inertia::render('Frontend/Generate/Index', [
            'gateways' => $gateways,
            'credit_fee' => $credit_fee,
            'images' => $images ?? [],
            'generatedImages' => $generatedImages,
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


        $gateway  = Gateway::where('status', 1)->findOrFail($request->gateway_id);

        $credit_fee = get_option('per_credit_fee');
        $total    = $request->credits / $credit_fee;

        $orderData['payable'] = $total * $gateway->multiply + $gateway->charge;
        $orderData['orders'] = [
            'user_id' => Auth::user()->id,
            'credits' => $request->credits,
            'total' => $request->total,
            'status' => 0,
        ];



        Session::put('order_credit_data', $orderData);
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

        $callback['success'] = url('/credit-order/pay/success');
        $callback['fail']    = url('/credit-order/pay/failed');
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
     * @param $status
     * @return \Illuminate\Http\Response
     */
    public function status($status)
    {

        abort_if(!Session::has('call_back') || !Session::has('order_credit_data'), 404);
        return $status == 'success' ? $this->success() : $this->faild();
    }

     /**
     * execute if payment has success
     *
     * @return \Illuminate\Http\Response
     */
    public function success()
    {
        abort_if(!Session::has('payment_info'), 404);


        $paymentInfo = Session::get('payment_info');

        Session::forget('payment_info');
        Session::forget('call_back');


        $orderData     = Session::get('order_credit_data');
        abort_if($paymentInfo['amount'] != $orderData['orders']['total'], 404);

        $order = new Creditlog();
        $order->user_id     = Auth::user()->id;
        $order->payment_id  = $paymentInfo['payment_id'];
        $order->gateway_id  = $paymentInfo['getway_id'];
        $order->price       = $paymentInfo['amount'];
        $order->credits     = $orderData['orders']['credits'];
        $order->status      = $paymentInfo['payment_status'] ?? 0;

        if (isset($paymentInfo['meta'])) {
            $order->meta    = json_encode($paymentInfo['meta']);
        }
        $order->save();

        if ($order->status == 1) {
            $user = User::query()->findOrFail(Auth::user()->id);
            $user->increment('credits', $orderData['orders']['credits']);
        }
        Session::forget('order_credit_data');
        return $order->status == 1 ? redirect('/generate') : redirect('/dashboard/credit-logs');
    }

     /**
     * execute if payment has fail
     *
     * @return \Illuminate\Http\Response
     */
    public function faild()
    {

        Session::forget('payment_info');
        Session::forget('call_back');
        Session::forget('order_credit_data');

        return redirect('/generate')->withErrors([
            'gateway_id' => __('Oops! We encountered an issue processing your payment. Please check your payment details and retry.'),
        ])->onlyInput('gateway_id');
    }
}
