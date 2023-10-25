<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Promptmodel;
use App\Traits\Uploader;
use Auth;
use Cache;
use Inertia\Inertia;
use Str;
class SubmodelController extends Controller
{
    use Uploader;

    public function __construct()
    {
        $this->middleware('permission:prompt-models');
    }

    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $prompt_group = Promptmodel::where('type','prompt_group')->findOrFail($id);

        $segments = request()->segments();

        $buttons = [
            [
                'name' => '<i class="fa fa-plus"></i>  &nbsp' . __('Create Model'),
                'url' => route('admin.prompt-sub-models.create',$id)
            ],
            [
                'name' =>  __('Back'),
                'url' => route('admin.prompt-model.show',$prompt_group->promptmodel_id)
            ],
            
        ];
       

        $models = Promptmodel::where('type','sub_models')->withCount('promptsrelation')->where('promptmodel_id',$id)->latest()->get();
        return Inertia::render('Admin/PromptModel/Group/Submodels/Index', compact('models','prompt_group', 'segments', 'buttons'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $segments = request()->segments();

        $buttons = [
            [
                'name' =>  __('Back'),
                'url' => route('admin.prompt-sub-model.index',$id)
            ],
        ];

        $prompt_group = Promptmodel::where('type','prompt_group')->findOrFail($id);

        return Inertia::render('Admin/PromptModel/Group/Submodels/Create', compact('segments', 'buttons','prompt_group'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id)
    {
       
        $validated = $request->validate([
            'preview' => 'required|image|max:5000',
            'name' => 'required|unique:promptmodels,title|max:100'           
        ]);

        $prompt_group = Promptmodel::where('type','prompt_group')->findOrFail($id);
      
        $model = new Promptmodel;
        $model->title = $request->name;
        $model->meta = $request->meta;
        $model->slug = Str::slug($request->name);
        $model->guide = $request->video_guide ?? null;
        $model->status = $request->status ?? false;
        $model->is_featured = $request->is_featured ?? false;
        $model->accept_image = $request->accept_image ?? false;
        $model->accept_profile_link = $request->accept_profile ?? false;
        $model->accept_image_size_measurement = $request->accept_image_ratio ?? false;
        $model->accept_negative_prompt = $request->negative_prompt ?? false;
        $model->accept_seed = $request->accept_seed ?? false;
       
        $model->promptmodel_id = $id;
        $model->type = 'sub_models';
        if($request->hasfile('preview')){
            $model->preview = $this->saveFile($request, 'preview');
        }
        $model->save();

        
        return to_route('admin.prompt-sub-model.index',$id); 
    }

    
 
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
       
        $model =  Promptmodel::where('type','sub_models')->findOrFail($id);
        $segments = request()->segments();

        $buttons = [
            [
                'name' =>  __('Back'),
                'url' => route('admin.prompt-sub-model.index',$model->promptmodel_id)
            ],
        ];

        return Inertia::render('Admin/PromptModel/Group/Submodels/Edit', compact('segments', 'buttons','model'));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'preview' => 'nullable|image|max:5000',
            'name' => 'required|max:100'     
        ]);

        $model =  Promptmodel::where('type','sub_models')->findOrFail($id);
        $model->title = $request->name;
        $model->meta = $request->meta;
        $model->slug = Str::slug($request->name);
        $model->guide = $request->video_guide ?? null;
        $model->status = $request->status ?? false;
        $model->is_featured = $request->is_featured ?? false;
        $model->accept_image = $request->accept_image ?? false;
        $model->accept_profile_link = $request->accept_profile ?? false;
        $model->accept_image_size_measurement = $request->accept_image_ratio ?? false;
        $model->accept_negative_prompt = $request->negative_prompt ?? false;
        $model->accept_seed = $request->accept_seed ?? false;
       
        if($request->hasfile('preview')){
            $this->removeFile($model->preview);
            $model->preview = $this->saveFile($request, 'preview');
        }

        $model->save();

        return to_route('admin.prompt-sub-model.index',$model->promptmodel_id); 
    }

}
