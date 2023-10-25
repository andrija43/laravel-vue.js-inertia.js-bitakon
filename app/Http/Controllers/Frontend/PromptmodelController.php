<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Prompt;
use App\Models\Promptcategory;
use App\Models\Promptmodel;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PromptmodelController extends Controller
{

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $promptmodel = Promptmodel::where('status', 1)
            ->where('type', 'parent_model')
            ->where('slug', $slug)
            ->firstOrFail();
        
        

        $promptsQuery = Prompt::where('status', 1)
            ->with(['promptmodel:id,title,created_at', 'user:id,name,username,created_at,avatar'])
            ->whereHas('promptmodel', function ($query) use ($promptmodel) {
                $query->where('slug', $promptmodel->slug);
            })
            ->withCount(['likes as is_liked' => function ($query) {
                $query->where('user_id', auth()->id());
            }])
            ->withAvg(['reviews' => function ($query) {
                $query->where('status', 1);
            }], 'star');

        $categories = Promptcategory::select('id', 'name', 'slug', 'created_at')
            ->whereHas('promptmodel', function ($query) use ($promptmodel) {
                $query->where('slug', $promptmodel->slug);;
            })->get();


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

        $seo['title'] = $promptmodel->title;
        $seo['site_name'] = $promptmodel->title;
        $seo['description'] = $promptmodel->meta['frontend_description'] ?? '';
        $seo['preview'] = asset($promptmodel->preview);      
      
        config()->set('seotools.metaDescription',$seo['description']);
        config()->set('seotools.site_name',$seo['title']);
        config()->set('seotools.current_url', url()->current());
        config()->set('seotools.metaImage',$seo['preview']);

        $promptmodel=collect($promptmodel)->only(['id', 'title', 'slug', 'created_at']);
        
        return Inertia::render('Frontend/PromptModel/Index', [
            'prompts' => $prompts,
            'seo' => $seo,
            'promptmodel' => $promptmodel,
            'categories' => $categories
        ]);
    }
}
