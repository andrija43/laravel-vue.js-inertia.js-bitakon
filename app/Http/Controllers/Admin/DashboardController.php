<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use App\Models\Creditlog;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Orderitem;
use App\Models\Payout;
use App\Models\User;
use App\Models\Prompt;
use Carbon\Carbon;
use Http;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DashboardController extends Controller
{

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $order_timeline = $request->order_timeline ?? 7;
        $sales_timeline = $request->sales_timeline ??  7;
        $earning_timeline = $request->earning_timeline ??  7;
        $credit_timeline = $request->credit_timeline ?? 7;
        $segments = request()->segments();
        $buttons = [];
        $todaysOrder = Order::whereDate('created_at', Carbon::today())->count();
        $pendingOrder = Order::where('status', 2)->count();
        $payoutRequest = Payout::query()->where('status', 'pending')->count();
        $promptRequest = Prompt::query()->where('status', 2)->count();

        $orderSales = Orderitem::join('orders', 'orderitems.order_id', '=', 'orders.id')
            ->selectRaw('sum(orderitems.commissions) as commissions, orders.created_at')
            ->whereBetween('orders.created_at', [now()->subDays($sales_timeline)->format('Y-m-d')." 00:00:00", today()->format('Y-m-d')." 23:59:59"])
            ->groupBy('orders.id')
            ->get()
            ->map(function ($q) {
                $data['commissions'] = str_replace(',', '', number_format($q->commissions, 2));
                $data['created_at'] = $q->created_at;

                return $data;
            });
            
        $orders = Orderitem::join('orders', 'orderitems.order_id', '=', 'orders.id')
            ->selectRaw('sum(orders.amount) as amount, orders.created_at')
            ->whereBetween('orders.created_at', [Carbon::now()->subDays($order_timeline)->format('Y-m-d')." 00:00:00", today()->format('Y-m-d')." 23:59:59"])
            ->groupBy('orders.id')
            ->get();

        $creditOrders = Creditlog::whereBetween('created_at', [now()->subDays($credit_timeline)->format('Y-m-d')." 00:00:00", today()->format('Y-m-d')." 23:59:59"])
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m-%d") as date, price')
            ->get();

        $orderTotalCommission = Orderitem::allJoined()
            ->whereBetween('orders.created_at', [now()->subDays($earning_timeline)->format('Y-m-d')." 00:00:00", today()->format('Y-m-d')." 23:59:59"])
            ->groupBy('orders.created_at')
            ->sum('commissions');
        $creditOrdersTotal = Creditlog::query()
            ->selectRaw('sum(price) as total_amount, sum(credits) as total_credits,created_at')
            ->whereBetween('created_at', [now()->subDays($earning_timeline)->format('Y-m-d')." 00:00:00", today()->format('Y-m-d')." 23:59:59"])
            ->first();

        $topCustomer = User::whereHas('orders')
            ->withCount('orders')
            ->orderByDesc('orders_count')->limit(5)
            ->get();
        $topSeller = Orderitem::allJoined()
            ->select('users.id', 'users.name', 'users.username', 'users.avatar', DB::raw('COUNT(prompts.id) as total_sold'))
            ->groupBy('users.id')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();
        $popularPrompts = Prompt::query()->orderByDesc('total_views')->limit(5)
            ->get();

        $recentOrders = Order::with('user')
            ->latest()
            ->take(6)
            ->get();

        $topPrompts = Orderitem::allJoined()
            ->selectRaw('count(orderitems.prompt_id) as total_sold, prompts.*')
            ->groupBy('orderitems.prompt_id')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();
        $pendingPrompt = Prompt::query()->where('status', 2)->limit(5)->get();
        $recentPrompt = Prompt::query()->with('user:id,name,created_at')->limit(5)->get();

        $topCollection = Collection::withCount('prompts')->orderByDesc('prompts_count')->limit(5)->get();
        $recentPayoutRequest = Payout::query()->with(['user:id,name,created_at', 'method'])
            ->latest()->limit(5)->get();


        return Inertia::render('Admin/Dashboard', [
            'segments' => $segments,
            'buttons' => $buttons,
            'todaysOrder' => $todaysOrder,
            'pendingOrder' => $pendingOrder,
            'payoutRequest' => $payoutRequest,
            'promptRequest' => $promptRequest,
            'orders' => $orders,
            'creditOrders' => $creditOrders,
            'earnings' => [(int) $orderTotalCommission, $creditOrdersTotal->total_amount],
            'topCustomer' => $topCustomer,
            'topSeller' => $topSeller,
            'popularPrompts' => $popularPrompts,
            'recentOrders' => $recentOrders,
            'topPrompts' => $topPrompts,
            'pendingPrompt' => $pendingPrompt,
            'recentPrompt' => $recentPrompt,
            'topCollection' => $topCollection,
            'recentPayoutRequest' => $recentPayoutRequest,
            'orderSales' => $orderSales,
            'creditOrdersTotal' => $creditOrdersTotal,
            'request' => $request
        ]);
    }

  
}
