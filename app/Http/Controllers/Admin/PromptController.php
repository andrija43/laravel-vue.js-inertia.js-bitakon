<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prompt;
use App\Models\Promptcategory;
use App\Models\Promptcategoryimage;
use App\Models\Promptfile;
use App\Models\Promptmodel;
use App\Models\Promptmodelrelation;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PromptController extends Controller
{

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $segments = request()->segments();
        $buttons = [];
        $prompts = Prompt::query();
        if (!empty($request->search)) {
            if (in_array($request->type, ['email', 'name'])) {
                $prompts = $prompts->whereHas('user', function ($q) use ($request) {
                    return $q->where($request->type, $request->search);
                });
            } else {
                $prompts = $prompts->where($request->type, 'LIKE', '%' . $request->search . '%');
            }
        }
        $prompts = $prompts->with('user:id,name,email,created_at')->withCount('orders')->latest()->paginate();
        $totalPrompts = Prompt::count();
        $activePrompts = Prompt::where('status', 1)->count();
        $inactivePrompts = Prompt::where('status', 0)->count();

        $type = $request->type ?? 'email';
        return Inertia::render('Admin/Prompt/Index', [
            'prompts' => $prompts,
            'buttons' => $buttons,
            'segments' => $segments,
            'totalPrompts' => $totalPrompts,
            'activePrompts' => $activePrompts,
            'inactivePrompts' => $inactivePrompts,
            'type' => $type,
            'request' => $request,
        ]);
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function pending(Request $request)
    {
        $segments = request()->segments();
        $buttons = [];
        $prompts = Prompt::query();
        if (!empty($request->search)) {
            if (in_array($request->type, ['email', 'name'])) {
                $prompts = $prompts->whereHas('user', function ($q) use ($request) {
                    return $q->where($request->type, $request->search);
                });
            } else {
                $prompts = $prompts->where($request->type, 'LIKE', '%' . $request->search . '%');
            }
        }
        $prompts = $prompts->where('status', 2)
            ->with('user:id,name,email,created_at')->latest()->paginate();
        $totalPrompts = Prompt::where('status', 2)->count();
        $last7DaysPrompts = Prompt::where('created_at', '>=', now()->subWeek())->where('status', 2)->count();
        $todayPrompts = Prompt::where('created_at', '>=', now()->today())->where('status', 2)->count();

        $type = $request->type ?? 'email';
        return Inertia::render('Admin/Prompt/Pending', [
            'prompts' => $prompts,
            'buttons' => $buttons,
            'segments' => $segments,
            'totalPrompts' => $totalPrompts,
            'lastWeekPrompts' => $last7DaysPrompts,
            'todayPrompts' => $todayPrompts,
            'type' => $type,
            'request' => $request,
        ]);
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function disable(Request $request)
    {
        $segments = request()->segments();
        $buttons = [];
        $prompts = Prompt::query();
        if (!empty($request->search)) {
            if (in_array($request->type, ['email', 'name'])) {
                $prompts = $prompts->whereHas('user', function ($q) use ($request) {
                    return $q->where($request->type, $request->search);
                });
            } else {
                $prompts = $prompts->where($request->type, 'LIKE', '%' . $request->search . '%');
            }
        }
        $prompts = $prompts->where('status', 0)
            ->with('user:id,name,email,created_at')->latest()->paginate();
        $totalPrompts = Prompt::where('status', 0)->count();
        $last7DaysPrompts = Prompt::where('updated_at', '>=', now()->subWeek())->where('status', 0)->count();
        $todayPrompts = Prompt::where('updated_at', '>=', now()->today())->where('status', 0)->count();

        $type = $request->type ?? 'email';
        return Inertia::render('Admin/Prompt/Disable', [
            'prompts' => $prompts,
            'buttons' => $buttons,
            'segments' => $segments,
            'totalPrompts' => $totalPrompts,
            'lastWeekPrompts' => $last7DaysPrompts,
            'todayPrompts' => $todayPrompts,
            'type' => $type,
            'request' => $request,
        ]);
    }

     /**
     * Show  the specified resource.
     *
     * @param  \App\Models\PayoutMethod  $Payoutmethod
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $segments = request()->segments();
        $buttons = [
            [
                'name' => '<i class="fa fa-arrow-left"></i>  &nbsp' . __('Back'),
                'url' => route('admin.prompt.index')
            ],
        ];
        $prompt = Prompt::where('id', $id)
            ->with('user:id,name,username,created_at,email,phone')
            ->withCount('likes')
            ->firstOrFail();
        $promptmodel = Promptmodel::where('type', 'parent_model')
            ->where('id', $prompt->promptmodel_id)->firstOrFail();

        $promptGroups = Promptmodel::where('promptmodel_id', $promptmodel->id)
            ->where('type', 'prompt_group')
            ->with('submodels')
            ->get();
        $promptCategory = Promptcategory::where('id', $prompt->promptcategory_id)->first();
        $promptcategoryimages = Promptcategoryimage::where('promptcategory_id', $prompt->promptcategory_id)->pluck('url');
        $promptFiles = Promptfile::where('prompt_id', $prompt->id)->first();

        $promptModelRelation = Promptmodelrelation::where('prompt_id', $prompt->id)->pluck('promptmodel_id');


        return Inertia::render('Admin/Prompt/Show', [
            'promptmodel' => $promptmodel,
            'prompt' => $prompt,
            'promptGroups' => $promptGroups ?? [],
            'promptCategory' => $promptCategory ?? [],
            'promptFiles' => $promptFiles,
            'promptcategoryimages' => $promptcategoryimages,
            'promptModelRelation' => $promptModelRelation,
            'buttons' => $buttons,
            'segments' => $segments,
        ]);
    }


     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $id)
    {
        $prompt = Prompt::findOrFail($id);

        $request->validate([
            'status' => 'required'
        ]);

        $prompt->update([
            'status' => $request->status
        ]);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $prompt = Prompt::findOrFail($id);

        $prompt->delete();
        return back();
    }
}
