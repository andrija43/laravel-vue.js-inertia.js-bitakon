<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class TopSellerController extends Controller
{

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sellers = DB::table('users')
            ->where('role','!=','admin')
            ->leftJoin('prompts', 'users.id', '=', 'prompts.user_id')
            ->leftJoin('orderitems', 'prompts.id', '=', 'orderitems.prompt_id')
            ->leftJoin('orders', 'orderitems.order_id', '=', 'orders.id')
            ->select('users.id', 'users.name', 'users.username', 'users.avatar', DB::raw('COUNT(orderitems.prompt_id) as total_sold'))
            ->when(request()->s_query, function ($query) {
                $query->where('users.name', 'like', '%' . request()->s_query . '%');
            })
            ->groupBy('users.id', 'users.name')
            ->orderBy(request()->sort ?? 'total_sold', request()->order ?? 'desc')
            ->paginate();

        $seo = get_option('seo_seller', true);
        $meta['title'] = $seo->site_name ?? '';
        $meta['site_name'] = $seo->site_name ?? '';
        $meta['description'] = $seo->matadescription ?? '';
        $meta['tags'] = $seo->matatag ?? '';
        $meta['preview'] = asset($seo->preview ?? '');

        config()->set('seotools.metaDescription',$meta['description']);
        config()->set('seotools.keyWords',$meta['tags']);
        config()->set('seotools.site_name',$meta['title']);
        config()->set('seotools.current_url', url()->current());
        config()->set('seotools.metaImage',$meta['preview']);

        return Inertia::render('Frontend/TopSeller/Index', [
            'sellers' => $sellers,
            'seo' => $meta
        ]);
    }
}
