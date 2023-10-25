<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Orderitem;
use App\Traits\Notifications;
use DB;
use Auth;
use Inertia\Inertia;

class OrderController extends Controller
{
    use Notifications;

    public function __construct()
    {
        $this->middleware('permission:order');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $segments = request()->segments();
        $buttons = [
            [
                'name' => '<i class="fi fi-rs-file-invoice-dollar"></i>&nbsp&nbsp' . __('Invoice Settings'),
                'url' => '#',
                'target' => '#addRecord',

            ],
            [
                'name' => '<i class="fi fi-rs-money-check-edit"></i>&nbsp&nbsp' . __('Currency Settings'),
                'url' => '#',
                'target' => '#currency',


            ],
            [
                'name' => '<i class="fi fi-rs-bank"></i>&nbsp&nbsp' . __('Tax Settings'),
                'url' => '#',
                'target' => '#taxModal',

            ],
            [
                'name' => '<i class="fi fi-rs-shop"></i>&nbsp&nbsp' . __('Author Fee'),
                'url' => '#',
                'target' => '#commision',

            ],
        ];



        $orders = Order::query();

        if (!empty($request->search)) {
            if ($request->type == 'email') {
                $orders = $orders->whereHas('user', function ($q) use ($request) {
                    return $q->where('email', $request->search);
                });
            } else {
                $orders = $orders->where($request->type, 'LIKE', '%' . $request->search . '%');
            }
        }

        $orders = $orders->with('user', 'gateway')->withCount('items')->latest()->paginate(20);

        $totalOrders = Order::count();
        $totalPendingOrders = Order::where('status', 2)->count();
        $totalCompleteOrders = Order::where('status', 1)->count();
        $totalDeclinedOrders = Order::where('status', 0)->count();
        $type = $request->type ?? 'email';

        $invoice = get_option('invoice_data', true);
        $currency = get_option('base_currency', true);
        $author_fee = get_option('author_fee', true);
        $tax = get_option('tax');

        return Inertia::render('Admin/Order/Index', [
            'segments' => $segments,
            'buttons' => $buttons,
            'orders' => $orders,
            'request' => $request,
            'totalOrders' => $totalOrders,
            'totalPendingOrders' => $totalPendingOrders,
            'totalCompleteOrders' => $totalCompleteOrders,
            'totalDeclinedOrders' => $totalDeclinedOrders,
            'author_fee' =>  $author_fee,
            'type' => $type,
            'invoice' => $invoice,
            'currency' => $currency,
            'tax' => $tax
        ]);
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $segments = request()->segments();
        $buttons = [
            [
                'name' => __('Orders'),
                'url' => '/admin/order'
            ],

        ];
        $order  = Order::with('user', 'gateway')->findOrFail($id);
        $invoice_data = get_option('invoice_data', true);
        $meta = json_decode($order->meta ?? '');
        $orderitems = Orderitem::query()->where('order_id', $id)
            ->with(['prompt.promptmodel:id,title,created_at'])
            ->latest()->get();
        return Inertia::render(
            'Admin/Order/Show',
            compact(
                'order',
                'orderitems',
                'invoice_data',
                'segments',
                'buttons',
                'meta'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $order  = Order::with('user')->findorFail($id);
        $order->status = $request->status;
        $order->save();

        return back();
    }
}
