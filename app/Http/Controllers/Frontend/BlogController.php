<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use Carbon\Carbon;
use App\Traits\Seo;
use Inertia\Inertia;
use Str;

class BlogController extends Controller
{
    use Seo;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $blogs = Post::where('type', 'blog')->where('lang', app()->getLocale());
        if (!empty($request->search)) {
            $blogs = $blogs->where('title', 'LIKE', '%' . $request->search . '%');
        }
        if (!empty($request->date)) {
            $date = Carbon::parse($request->date);
            $blogs = $blogs->whereDate('created_at', $date);
        }
        $blogs = $blogs->with('preview', 'categories')->where('status', 1)->latest()->paginate(6);

        $recent_blogs = Post::where('type', 'blog')->where('lang', app()->getLocale())->with('shortDescription', 'preview')->where('status', 1)->latest()->take(4)->get();

        $categories = Category::where('type', 'blog_category')->whereHas('postcategories')->withCount('postcategories')->where('lang', app()->getLocale())->get();

        $tags = Category::where('type', 'tags')->whereHas('postcategories')->where('lang', app()->getLocale())->get();

        $seo = get_option('seo_blog',true);
        $meta['title'] = $seo->site_name ?? '';
        $meta['site_name'] = $seo->site_name ?? '';
        $meta['description'] = $seo->matadescription ?? '';
        $meta['tags'] = $seo->matatag ?? '';
        $meta['preview'] = asset($seo->preview ?? '');

        $this->pageMetaData($meta);

        config()->set('seotools.metaDescription',$meta['description']);
        config()->set('seotools.keyWords',$meta['tags']);
        config()->set('seotools.site_name',$meta['title']);
        config()->set('seotools.current_url', url()->current());
        config()->set('seotools.metaImage',$meta['preview']);
       
        $breadcrumb = asset('assets/img/breadcrumb/breadcrumb-shape-1.png');

        return Inertia::render('Frontend/Blog/Index', compact('blogs', 'request', 'recent_blogs', 'categories', 'tags', 'seo', 'breadcrumb'));
    }


     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function category(Request $request, $slug, $id)
    {
        $category = Category::where('type', 'blog_category')->where('status', 1)->findorFail($id);

        $blogs = Post::where('type', 'blog')->where('lang', app()->getLocale());
        if (!empty($request->search)) {
            $blogs = $blogs->where('title', 'LIKE', '%' . $request->search . '%');
        }
        $blogs = $blogs->with('shortDescription', 'preview')->whereHas('postcategories', function ($query) use ($id) {
            return $query->where('category_id', $id);
        })->where('status', 1)->latest()->paginate(4);

        $recent_blogs = Post::where('type', 'blog')->where('lang', app()->getLocale())->with('shortDescription', 'preview')->where('status', 1)->latest()->take(4)->get();

        $categories = Category::where('type', 'blog_category')->where('status', 1)->withCount('postcategories')->whereHas('postcategories')->where('lang', app()->getLocale())->get();
        $tags = Category::where('type', 'tags')->where('status', 1)->whereHas('postcategories')->where('lang', app()->getLocale())->get();

        $meta['title'] = $category->title ?? '';

        $this->pageMetaData($meta);

        $seo['site_name'] = $category->title;
        $breadcrumb = asset('assets/img/breadcrumb/breadcrumb-shape-1.png');

        return Inertia::render('Frontend/Blog/Index', compact('blogs', 'request', 'recent_blogs', 'categories', 'tags', 'seo', 'breadcrumb'));
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function tag(Request $request, $slug, $id)
    {
        $category = Category::where('type', 'tags')->where('status', 1)->findorFail($id);

        $blogs = Post::where('type', 'blog')->where('lang', app()->getLocale());
        if (!empty($request->search)) {
            $blogs = $blogs->where('title', 'LIKE', '%' . $request->search . '%');
        }
        $blogs = $blogs->with('shortDescription', 'preview')->whereHas('postcategories', function ($query) use ($id) {
            return $query->where('category_id', $id);
        })->where('status', 1)->latest()->paginate(4);

        $recent_blogs = Post::where('type', 'blog')->where('lang', app()->getLocale())->with('shortDescription', 'preview')->where('status', 1)->latest()->take(4)->get();

        $categories = Category::where('type', 'blog_category')->withCount('postcategories')->whereHas('postcategories')->where('status', 1)->where('lang', app()->getLocale())->get();
        $tags = Category::where('type', 'tags')->whereHas('postcategories')->where('status', 1)->where('lang', app()->getLocale())->get();

        $meta['title'] = $category->title ?? '';
        $meta['site_name'] = $category->title ?? '';
        
        
        $this->pageMetaData($meta);

        $seo = $meta;

        $breadcrumb = asset('assets/img/breadcrumb/breadcrumb-shape-1.png');


        return Inertia::render('Frontend/Blog/Index', compact('blogs', 'request', 'recent_blogs', 'categories', 'tags', 'seo', 'breadcrumb'));
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $blog = Post::where('type', 'blog')->with('shortDescription', 'longDescription', 'tags', 'preview', 'seo', 'categories')->where('status', 1)->where('slug', $slug)->first();
        abort_if(empty($blog), 404);


        $categories = Category::where('type', 'blog_category')->whereHas('postcategories')->withCount('postcategories')->where('status', 1)->where('lang', app()->getLocale())->get();

        $tags = Category::where('type', 'tags')->whereHas('postcategories')->where('status', 1)->where('lang', app()->getLocale())->get();

        $recent_blogs = Post::where('type', 'blog')->where('lang', app()->getLocale())->with('shortDescription', 'preview')->where('status', 1)->latest()->take(4)->get();

        $seo = json_decode($blog->seo->value ?? '');

        $meta['title'] = $seo->title ?? '';
        $meta['site_name'] = $seo->title ?? '';
        $meta['description'] = $seo->description ?? '';
        $meta['tags'] = $seo->tags ?? '';
        $meta['preview'] = asset($blog->preview->value ?? '');

        $this->pageMetaData($meta);

        $seo = $meta;
        
        config()->set('seotools.metaDescription',$meta['description']);
        config()->set('seotools.keyWords',$meta['tags']);
        config()->set('seotools.site_name',$meta['title']);
        config()->set('seotools.current_url', url()->current());
        config()->set('seotools.metaImage',$meta['preview']);

        $nextBlog = Post::where('type', 'blog')->where('id', '>', $blog->id)->where('status', 1)->first();
        $lastBlog = Post::where('type', 'blog')->where('id', '<', $blog->id)->where('status', 1)->first();


        return Inertia::render('Frontend/Blog/Show', compact('blog', 'categories', 'tags', 'recent_blogs', 'seo', 'nextBlog', 'lastBlog'));
    }
}
