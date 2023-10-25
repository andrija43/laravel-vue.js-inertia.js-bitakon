<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use App\Models\Prompt;
use App\Models\Promptcategory;
use App\Models\Promptmodel;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CollectionController extends Controller
{

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $collections = Collection::query()->where('status', 1)
            ->whereHas('prompts', function ($q) {
                return $q->where('status', 1);
            })
            ->with(['prompt_previews', 'user:id,name,avatar,created_at'])
            ->withCount(['prompts' => function ($q) {
                $q->where('status', 1);
            }])
            ->orderBy(request()->sort ?? 'created_at', request()->order ?? 'desc')
            ->paginate(9);

        $seo = get_option('seo_collection', true);
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

        return Inertia::render('Frontend/Collection/Index', [
            'collections' => $collections,
            'seo' => $meta
        ]);
    }

     /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $promptmodels = Promptmodel::where('status', 1)
            ->where('type', 'parent_model')
            ->select('id', 'title', 'slug', 'created_at')->get();

        $collection = Collection::where('status', 1)
            ->where('slug', $slug)
            ->select('id', 'name', 'slug', 'created_at', 'preview')->firstOrFail();

        $promptsQuery = Prompt::where('status', 1)
            ->with(['promptmodel:id,title,created_at', 'user:id,name,username,created_at,avatar'])
            ->whereHas('collection', function ($query) use ($collection) {
                $query->where('slug', $collection->slug);
            })
            ->withCount(['likes as is_liked' => function ($query) {
                $query->where('user_id', auth()->id());
            }])
            ->withAvg(['reviews' => function ($query) {
                $query->where('status', 1);
            }], 'star');
        $categories = [];
        if (request()->filled('model')) {
            $promptsQuery->whereHas('promptmodel', function ($query) {
                $query->where('slug', request()->model)
                    ->orWhere('title', 'like', '%' . request()->model . '%');
            });
            $categories = Promptcategory::select('id', 'name', 'slug', 'created_at')
                ->whereHas('promptmodel', function ($query) {
                    $query->where('slug', request()->model);;
                })->get();
        }

        if (request()->filled('category')) {
            $promptsQuery->whereHas('category', function ($query) {
                $query->where('slug', request()->category);
            });
        }
        if (request()->filled('rating')) {
            $promptsQuery->whereHas('reviews', function ($query) {
                $query->where('star', request()->rating);
            });
        }
        $prompts = $promptsQuery->orderBy(request()->sort ?? 'created_at', request()->order ?? 'desc')
            ->paginate();

        $seo['title'] = $collection->name;
        $seo['site_name'] = $collection->name;
        $seo['preview'] = asset($collection->preview);

       
       
        config()->set('seotools.site_name',$seo['title']);
        config()->set('seotools.current_url', url()->current());
        config()->set('seotools.metaImage',$seo['preview']);

        return Inertia::render('Frontend/Collection/Show', [
            'prompts' => $prompts,
            'seo' => $seo,
            'collection' => $collection,
            'promptmodels' => $promptmodels,
            'categories' => $categories,
        ]);
    }
}
