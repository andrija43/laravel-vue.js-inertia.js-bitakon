<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Prompt;
use App\Models\Promptcategory;
use App\Models\Promptcategoryimage;
use App\Models\Promptfile;
use App\Models\Promptmodel;
use App\Models\Promptmodelrelation;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PromptController extends Controller
{

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $promptmodels = Promptmodel::where('status', 1)
            ->where('type', 'parent_model')
            ->select('id', 'title', 'slug', 'created_at')->get();

        $promptsQuery = Prompt::where('status', 1)
            ->when(request()->filled('s_query'), function ($query) {
                $query->where('title', 'like', '%' . request()->s_query . '%');
            })
            ->with(['promptmodel:id,title,created_at', 'user:id,name,username,created_at,avatar'])
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
            ->paginate(18);

        $seo = get_option('seo_prompts', true);
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

        return Inertia::render('Frontend/Prompt/Index', [
            'prompts' => $prompts,
            'promptmodels' => $promptmodels,
            'categories' => $categories,
            'seo' => $meta,
            'searchQuery' => request()->s_query,
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
        $prompt = Prompt::where('slug', $slug)
            ->where('status', 1)
            ->with([
                'user:id,name,username,created_at,avatar',
                'collection:id,name,slug,created_at,preview',
                'promptmodel:id,title,slug,created_at,has_submodel',
                'discount'
            ])
            ->withCount(['likes as is_liked' => function ($query) {
                $query->where('user_id', auth()->id());
            }])
            ->firstOrFail();

        $promptCategory = Promptcategory::where('id', $prompt->promptcategory_id)->first();
        $promptcategoryimages = Promptcategoryimage::where('promptcategory_id', $prompt->promptcategory_id)->pluck('url');

        if ($prompt->promptmodel->has_submodel) {
            $promptModelRelation = Promptmodelrelation::where('prompt_id', $prompt->id)->pluck('promptmodel_id');

            $promptSubmodels = Promptmodel::whereIn('id', $promptModelRelation)
                ->with('model:id,title,slug,created_at,promptmodel_id')
                ->where('type', 'sub_models')
                ->get();
        }

        $meta = json_decode($prompt->meta ?? '');
        $seo['title'] = $prompt->title;
        $seo['site_name'] = $prompt->title;
        $seo['description'] = $meta->description ?? '';
        $seo['tags'] = $prompt->promptmodel->title ?? '';
        $seo['preview'] = asset($prompt->preview != null ? $prompt->preview : ($meta->preview ?? ''));

        config()->set('seotools.metaDescription',$seo['description']);
        config()->set('seotools.keyWords',$seo['tags']);
        config()->set('seotools.site_name',$seo['title']);
        config()->set('seotools.current_url', url()->current());
        config()->set('seotools.metaImage',$seo['preview']);

        return Inertia::render('Frontend/Prompt/Show', [
            'prompt' => $prompt,
            'seo' => $seo,
            'promptSubmodels' => $promptSubmodels ?? [],
            'promptCategory' => $promptCategory ?? [],
            'promptcategoryimages' => $promptcategoryimages,
            'promptModelRelation' => $promptModelRelation ?? ''
        ]);
    }
}
