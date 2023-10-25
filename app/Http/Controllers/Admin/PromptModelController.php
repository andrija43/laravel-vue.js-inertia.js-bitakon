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

class PromptModelController extends Controller
{

    use Uploader;

    public function __construct()
    {
        $this->middleware('permission:prompt-models');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $segments = request()->segments();

        $buttons = [
            [
                'name' => '<i class="fa fa-plus"></i>  &nbsp' . __('Create Model'),
                'url' => route('admin.prompt-model.create')
            ],
        ];
        $totalModels = Promptmodel::where('type', 'parent_model')->count();
        $totalGroupModels = Promptmodel::where('type', 'prompt_group')->count();
        $totalSubModels = Promptmodel::where('type', 'sub_models')->count();


        $models = Promptmodel::where('type', 'parent_model')->withCount('prompts')->latest()->get();
        return Inertia::render('Admin/PromptModel/Index', compact('models', 'segments', 'buttons','totalModels','totalGroupModels','totalSubModels'));
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
                'url' => route('admin.prompt-model.index')
            ],
        ];

        return Inertia::render('Admin/PromptModel/Create', compact('segments', 'buttons'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        $validated = $request->validate([
            'preview' => 'required|image|max:5000',
            'icon' => 'required|image|max:1000',
            'name' => 'required|unique:promptmodels,title|max:100'
        ]);

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
        $model->has_submodel = $request->has_submodel ?? false;
        $model->type = 'parent_model';
        if ($request->hasfile('preview')) {
            $model->preview = $this->saveFile($request, 'preview');
        }
        if ($request->hasfile('icon')) {
            $this->removeFile($model->icon);
            $model->icon = $this->saveFile($request, 'icon');
        }
        $model->save();

        if ($model->submodel) {
            return to_route('admin.prompt-model-group.create', $model->id);
        }
        return to_route('admin.prompt-model.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeSubmodel(Request $request, $id)
    {

        $validated = $request->validate([
            'name' => 'required|max:100',
            'naselect_instructione' => 'nullable|max:150'
        ]);
        $model = new Promptmodel;
        $model->title = $request->name;
        $model->slug = $request->select_instruction ?? null;
        $model->promptmodel_id = $id;
        $model->status = $request->status ?? false;
        $model->type = 'prompt_group';
        $model->save();

        return back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateSubmodel(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|max:100',
            'naselect_instructione' => 'nullable|max:150'
        ]);
        $model =  Promptmodel::where('type', 'prompt_group')->findOrFail($id);
        $model->title = $request->name;
        $model->slug = $request->select_instruction;
        $model->status = $request->status ?? false;
        $model->save();

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $model =  Promptmodel::where('type', 'parent_model')->findOrFail($id);
        
        $groups = Promptmodel::where('promptmodel_id',$id)->withCount('submodels')->latest()->get();
        $segments = request()->segments();

        $buttons = [
            [
                'name' => '<i class="fa fa-plus"></i>&nbsp' . __('Create a group'),
                'url' => '#',
                'components' => 'data-toggle="modal" data-target="#addRecord" id="add_record"',
                'is_button' => true,
                'target' => '#addRecord',
            ],
            [
                'name' =>  __('Back'),
                'url' => route('admin.prompt-model.index')
            ],
        ];

        return Inertia::render('Admin/PromptModel/Group/Index', compact('segments', 'buttons', 'model', 'groups'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $model =  Promptmodel::where('type', 'parent_model')->findOrFail($id);
        $segments = request()->segments();

        $buttons = [
            [
                'name' =>  __('Back'),
                'url' => route('admin.prompt-model.index')
            ],
        ];

        return Inertia::render('Admin/PromptModel/Edit', compact('segments', 'buttons', 'model'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $validatedData = $request->validate([
            'model.preview' => 'nullable|image|max:5000',
            'model.icon' => 'nullable|image|max:1000',
            'model.name' => 'required|max:100'
        ]);

        $model =  Promptmodel::where('type', 'parent_model')->findOrFail($id);
        $model->title = $request['model']['name'];
        $model->meta = $request['model']['meta'];
        $model->slug = Str::slug($request['model']['name']);
        $model->guide = $request['model']['video_guide'] ?? null;
        $model->status = $request['model']['status'] ?? false;
        $model->is_featured = $request['model']['is_featured'] ?? false;
        $model->accept_image = $request['model']['accept_image'] ?? false;
        $model->accept_profile_link = $request['model']['accept_profile'] ?? false;
        $model->accept_image_size_measurement = $request['model']['accept_image_ratio'] ?? false;
        $model->accept_negative_prompt = $request['model']['negative_prompt'] ?? false;
        $model->accept_seed = $request['model']['accept_seed'] ?? false;
        $model->has_submodel = $request['model']['has_submodel'] ?? false;
        if ($request->hasFile('model.preview')) {
            $this->removeFile($model->preview);
            $model->preview = $this->saveFile($request, 'model.preview');
        }
        if ($request->hasFile('model.icon')) {
            $this->removeFile($model->icon);
            $model->icon = $this->saveFile($request, 'model.icon');
        }

        $model->save();

        return to_route('admin.prompt-model.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $model =  Promptmodel::findOrFail($id);
        $this->removeFile($model->preview);
        $model->delete();
        return back();
    }
}
