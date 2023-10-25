<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Post;
use App\Models\Option;
use App\Models\Plan;
use App\Models\Slider;
use App\Traits\Seo;
use Cache;
use Inertia\Inertia;

class HomeController extends Controller
{
    use Seo;

    /**
     * Display a home page of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!file_exists(base_path('public/uploads/installed'))) {
            return redirect('/install');
        }

        $home = get_option('home-page', true,true);
       
        $theme_path = get_option('theme_path');

        $seo = get_option('seo_home', true);
        $meta['title'] = $seo->site_name ?? '';
        $meta['site_name'] = $seo->site_name ?? '';
        $meta['description'] = $seo->matadescription ?? '';
        $meta['tags'] = $seo->matatag ?? '';
        $meta['preview'] = asset($seo->preview ?? '');
        $pagePath = 'Frontend/' . $theme_path . '/Index';

        config()->set('seotools.metaDescription',$seo->matadescription ?? '');
        config()->set('seotools.keyWords',$seo->matatag ?? '');
        config()->set('seotools.site_name',$seo->site_name ?? '');
        config()->set('seotools.current_url', url()->current());
        config()->set('seotools.metaImage',asset($seo->preview ?? ''));

        return Inertia::render($pagePath, [
            'home' => $home?->about ?? [],
            'qr_image' => $home?->qr_code ?? null,
            'cta' => $home?->cta ?? null,
            'seo' => $meta,
        ]);
    }


   


    /**
     * Display  about page of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function about()
    {
        $about = get_option('about', true);
        $primary_data = get_option('primary_data', true);

        $teams = Post::where('type', 'team')->with(['preview', 'excerpt'])->latest()->take(5)->get();
        $brands = Category::whereType('brand')->latest()->get();

        $marquee = explode(",",$about->marquee ?? '');

        $seo = get_option('seo_about', true);
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

        return Inertia::render('Frontend/About/Index', [
            'about' => $about,
            'marquee' => $marquee,
            'teams' => $teams,
            'brands' => $brands,
            'primary_data' => $primary_data,
            'seo' => $meta
        ]);
    }


    /**
     * Display  faq page of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function faq()
    {
        $faqs = Post::where('type', 'faq')->where('lang', app()->getLocale())->with('excerpt')->latest()->get();

        $seo = get_option('seo_faq', true);
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

        return Inertia::render('Frontend/Faq/Index', [
            'seo' => $meta,
            'faqs' => $faqs
        ]);
    }


    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function page($slug)
    {
        $page = Post::where('status', 1)->where('type', 'page')->with('seo', 'description')->where('slug', $slug)->first();
        abort_if(empty($page), 404);

        $seo = json_decode($page->seo->value ?? '');
        $primary_data =  get_option('primary_data',true);
        
        $meta['title'] = $seo->title ?? '';
        $meta['site_name'] = $seo->title ?? '';
        $meta['description'] = $seo->description ?? '';
        $meta['tags'] = $seo->tags ?? '';
        $meta['preview'] = asset($primary_data->logo ?? '');

        $seo = $meta;
       
        config()->set('seotools.metaDescription',$meta['description']);
        config()->set('seotools.keyWords',$meta['tags']);
        config()->set('seotools.site_name',$meta['title']);
        config()->set('seotools.current_url', url()->current());
        config()->set('seotools.metaImage',$meta['preview']);

        $breadcrumb = asset('assets/img/breadcrumb/breadcrumb-shape-1.png');

        return Inertia::render('Frontend/Page', compact('page', 'seo', 'breadcrumb'));
    }
}
