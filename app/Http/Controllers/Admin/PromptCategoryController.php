<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promptcategory;
use App\Models\Promptcategoryimage;
use App\Models\Promptmodel;
use App\Traits\Uploader;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PromptCategoryController extends Controller
{
    use Uploader;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $segments = request()->segments();
        $buttons = [
            [
                'name' => '<i class="fa fa-plus"></i>&nbsp' . __('Create prompt category'),
                'url' => route('admin.prompt-category.create'),
            ]
        ];
        $promptcategory = Promptcategory::latest()->with('promptmodel')->withCount('prompts')->paginate(20);
        $totalCategory = Promptcategory::count();
        $activeCategory = Promptcategory::where('status', 1)->count();
        $inactiveCategory = Promptcategory::where('status', 0)->count();
        return Inertia::render('Admin/PromptCategory/Index', [
            'promptcategory' => $promptcategory,
            'buttons' => $buttons,
            'segments' => $segments,
            'totalCategory' => $totalCategory,
            'totalActiveCategory' => $activeCategory,
            'totalInactiveCategory' => $inactiveCategory
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $segments = request()->segments();

        $buttons = [
            [
                'name' =>  __('Back'),
                'url' => route('admin.prompt-category.index')
            ],
        ];
        $promptModels = Promptmodel::where('type', 'parent_model')->latest()->get();
        return Inertia::render('Admin/PromptCategory/Create', [
            'buttons' => $buttons,
            'segments' => $segments,
            'promptModels' => $promptModels
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'preview' => 'required|image|max:5000',
            'name' => 'required|string|max:100',
            'promptmodel_id' => 'required|exists:promptmodels,id'
        ]);
        if ($request->hasFile('preview')) {
            $preview = $this->saveFile($request, 'preview');
        }

        Promptcategory::create([
            'name' => $request->name,
            'promptmodel_id' => $request->promptmodel_id,
            'preview' => $preview ?? null,
            'slug' => str()->slug($request->name),
            'status' => $request->status ? true : false,
            'is_filterable' => $request->is_filterable ? true : false,
        ]);

        return to_route('admin.prompt-category.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $segments = request()->segments();
        $buttons = [
            [
                'name' => '<i class="fa fa-plus"></i>&nbsp' . __('Add Image'),
                'url' => '#',
                'components' => 'data-toggle="modal" data-target="#addRecord" id="add_record"',
                'is_button' => true,
                'target' => '#addRecord',
            ]
        ];
        $promptcategory = Promptcategory::findOrFail($id);
        $promptcategoryimages = Promptcategoryimage::where('promptcategory_id', $id)->paginate(20);
        return Inertia::render('Admin/PromptCategory/Show', [
            'buttons' => $buttons,
            'segments' => $segments,
            'promptcategory' => $promptcategory,
            'promptcategoryimages' => $promptcategoryimages,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $segments = request()->segments();

        $buttons = [
            [
                'name' =>  __('Back'),
                'url' => route('admin.prompt-category.index')
            ],
        ];
        $promptModels = Promptmodel::where('type', 'parent_model')->latest()->get();
        $promptcategory = Promptcategory::findOrFail($id);
        return Inertia::render('Admin/PromptCategory/Edit', [
            'buttons' => $buttons,
            'segments' => $segments,
            'promptModels' => $promptModels,
            'promptcategory' => $promptcategory
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $id)
    {
        $category = Promptcategory::findOrFail($id);
        $request->validate([
            'category.preview' => 'nullable|image|max:5000',
            'category.name' => 'required|string|max:100',
            'category.promptmodel_id' => 'required|exists:promptmodels,id'
        ]);
        if ($request->hasFile('category.preview')) {
            $preview = $this->saveFile($request, 'category.preview');
        }
        $category->update([
            'name' => $request['category']['name'],
            'preview' => $preview ?? $category->preview,
            'slug' => str()->slug($request['category']['name']),
            'status' => $request['category']['status'] ? true : false,
            'is_filterable' => $request['category']['is_filterable'] ? true : false,
        ]);

        return to_route('admin.prompt-category.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $id)
    {
        $category = Promptcategory::findOrFail($id);
        $this->removeFile($category->preview);
        $category->delete();
        return back();
    }
}
