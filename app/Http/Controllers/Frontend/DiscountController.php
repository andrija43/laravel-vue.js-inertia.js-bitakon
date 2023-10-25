<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Prompt;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DiscountController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $prompts = Prompt::where('status', 1)
            ->has('discount')
            ->when(request()->filled('s_query'), function ($query) {
                $query->where('title', 'like', '%' . request()->s_query . '%');
            })
            ->with(['promptmodel:id,title,created_at', 'user:id,name,username,created_at,avatar', 'discount'])
            ->withCount(['likes as is_liked' => function ($query) {
                $query->where('user_id', auth()->id());
            }])
            ->orderBy(request()->sort ?? 'created_at', request()->order ?? 'desc')
            ->paginate();
        
        $seo = get_option('seo_discount',true);
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
        
        return Inertia::render('Frontend/Discount/Index', [
            'prompts' => $prompts,
            'seo' => $meta
        ]);
    }
}
