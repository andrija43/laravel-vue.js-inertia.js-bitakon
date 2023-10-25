<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Follower;
use App\Models\Orderitem;
use App\Models\Prompt;
use Inertia\Inertia;

class AccountController extends Controller
{
    public function index()
    {
        $timeline = request('timeline') ?? 30;

        $dailyEarnings = Orderitem::byAuthUser(auth()->user()->id)
            ->selectRaw('DATE(orders.created_at) as date, SUM(orderitems.seller_amount) as total_sales, count(orderitems.id) as total_items')
            ->whereBetween('orders.created_at', [now()->subDays($timeline), today()])
            ->groupBy('date')
            ->where('is_calculated', 1)
            ->get();
        $totalEarnings = Orderitem::byAuthUser(auth()->user()->id)
            ->selectRaw('sum(orderitems.seller_amount) as total_earning')
            ->whereBetween('orders.created_at', [now()->subDays($timeline), today()])
            ->where('is_calculated', 1)
            ->first();
        $monthlyOrders = Orderitem::byAuthUser(auth()->user()->id)
            ->selectRaw('sum(orderitems.seller_amount) as amount, count(orderitems.id) as total_orders, DATE(orders.created_at) as date')
            ->whereBetween('orders.created_at', [now()->subDays(30), today()])
            ->groupBy('orders.created_at')
            ->where('is_calculated', 1)
            ->get();
        $recentOrders = Orderitem::byAuthUser(auth()->user()->id)
            ->selectRaw('orders.invoice_no, users.name, orders.created_at, count(orderitems.id) as total_items, orders.status')
            ->groupBy('orders.created_at')
            ->where('is_calculated', 1)
            ->take(10)
            ->get();
        $topSold  = Orderitem::byAuthUser(auth()->user()->id)
            ->selectRaw('prompts.*, users.name, users.avatar, promptmodels.title as model_title, count(orderitems.id) as total_sold')
            ->groupBy('prompts.id', 'users.name')
            ->orderBy('total_sold', 'desc')
            ->where('is_calculated', 1)
            ->take(10)
            ->get();

        return Inertia::render('Frontend/Account/Index', [
            'totalEarnings' => $totalEarnings,
            'dailyEarnings' => $dailyEarnings,
            'dailyEarningSales' => array_map(function ($item) {
                return $item['total_sales'];
            }, $dailyEarnings->toArray()),
            'dailyEarningDates' => array_map(function ($item) {
                return $item['date'];
            }, $dailyEarnings->toArray()),
            'monthlyOrders' => $monthlyOrders,
            'monthlyOrdersTotal' => $monthlyOrders->sum('amount'),
            'recentOrders' => $recentOrders,
            'topSold' => $topSold,
            'timeline' => $timeline,
        ]);
    }

    public function sales()
    {
        $type = request('type') ?? 'monthly';
        $dateFormat = match (request('type')) {
            'yearly' => "%Y",
            'monthly' => "%M %Y",
            default => "%d, %M %Y",
        };
        $topSold  = Orderitem::byAuthUser(auth()->user()->id)
            ->selectRaw('prompts.*, users.name, users.avatar, promptmodels.title as model_title, count(orderitems.id) as total_sold')
            ->groupBy('prompts.id', 'users.name')
            ->orderBy('total_sold', 'desc')
            ->take(10)
            ->where('is_calculated', 1)
            ->get();
        $startDate = now()->startOfMonth()->toDateString();
        $endDate = now()->endOfMonth()->toDateString();
        $monthTotal = Orderitem::byAuthUser(auth()->user()->id)
            ->selectRaw('sum(orderitems.amount) as month_total,count(orderitems.id) as total_items')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->where('is_calculated', 1)
            ->first();
        $totalSales = Orderitem::byAuthUser(auth()->user()->id)
            ->selectRaw('sum(orderitems.amount) as total_sales')
            ->where('is_calculated', 1)
            ->first();
        $dailySales = Orderitem::byAuthUser(auth()->user()->id)
            ->selectRaw('DATE(orders.created_at) as date, SUM(orderitems.amount) as total_sales, count(orderitems.id) as total_items')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->where('is_calculated', 1)
            ->get();

        $itemSales = Orderitem::byAuthUser(auth()->user()->id)
            ->selectRaw("DATE_FORMAT(orders.created_at, '$dateFormat') as date, SUM(orderitems.amount) as total_sales, COUNT(orderitems.id) as total_items")
            ->when($type === 'yearly', function ($q) {
                $q->groupByRaw('YEAR(orders.created_at)');
            })
            ->when($type === 'monthly', function ($q) {
                $q->whereYear('orders.created_at', now()->year)
                    ->groupByRaw('MONTH(orders.created_at)');
            })
            ->when($type === 'daily', function ($q) {
                $q->whereYear('orders.created_at', now()->year)
                    ->whereMonth('orders.created_at', now()->month)
                    ->groupByRaw('DAY(orders.created_at)');
            })
            ->where('is_calculated', 1)
            ->paginate(1)->withQueryString();
        $salesCount = Orderitem::byAuthUser(auth()->user()->id)
            ->where('is_calculated', 1)
            ->count();

        return Inertia::render('Frontend/Account/Sales/Index', [
            'topSold' => $topSold,
            'monthTotal' => $monthTotal,
            'totalSales' => $totalSales,
            'dailySales' => $dailySales,
            'itemSales' => $itemSales,
            'salesCount' => $salesCount,
            'requestType' => request('type'),
        ]);
    }
    public function purchase()
    {
        $orders = Orderitem::byAuthUser(auth()->user()->id, 'orders.user_id')
            ->selectRaw('prompts.*, users.name, users.avatar, users.username, promptmodels.title as model_title')
            ->groupBy('prompts.id')
            ->orderBy('orders.created_at', 'desc')
            ->where('is_calculated', 1)
            ->paginate(12);
        return Inertia::render('Frontend/Account/Purchase/Index', [
            'orders' => $orders,
        ]);
    }
    public function favorite()
    {
        $favorites = Prompt::query()
            ->where('user_id', auth()->id())
            ->with('promptmodel:id,title,created_at')
            ->whereHas('likes', function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->withCount(['likes as is_liked' => function ($query) {
                $query->where('user_id', auth()->id());
            }])
            ->latest()->paginate();

        return Inertia::render('Frontend/Account/Favorite/Index', [
            'favorites' => $favorites
        ]);
    }
    public function followers()
    {
        $followers = Follower::where('user_id', auth()->user()->id)->with('follower')->paginate(12);
        return Inertia::render('Frontend/Account/Follower/Index', [
            'followers' => $followers
        ]);
    }
    public function followings()
    {
        $followings = Follower::where('follower_id', auth()->user()->id)->with('user')->paginate(12);
        return Inertia::render('Frontend/Account/Following/Index', [
            'followings' => $followings
        ]);
    }
}