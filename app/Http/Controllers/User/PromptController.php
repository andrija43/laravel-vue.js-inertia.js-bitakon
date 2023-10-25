<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use App\Models\Discount;
use Illuminate\Http\Request;
use App\Models\Prompt;
use App\Models\Promptcategory;
use App\Models\Promptcategoryimage;
use App\Models\Promptfile;
use App\Models\Promptmodel;
use App\Models\Promptmodelrelation;
use App\Traits\Uploader;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Str;
use Auth;

class PromptController extends Controller
{
    use Uploader;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prompts = Prompt::query()
            ->where('user_id', auth()->id())
            ->with(['promptmodel:id,title,created_at', 'user:id,username,avatar,name,created_at'])
            ->withCount(['likes as is_liked' => function ($query) {
                $query->where('user_id', auth()->id());
            }])
            ->withAvg('reviews', 'star')
            ->latest()->paginate();
        $activePrompts = Prompt::where('user_id', auth()->id())->where('status', 1)->count();
        $pendingPrompts = Prompt::where('user_id', auth()->id())->where('status', 2)->count();
        $disabledPrompts = Prompt::where('user_id', auth()->id())->where('status', 0)->count();

        return Inertia::render('Frontend/Account/Prompt/Index', [
            'prompts' => $prompts,
            'activePrompts' => $activePrompts,
            'pendingPrompts' => $pendingPrompts,
            'disabledPrompts' => $disabledPrompts,
        ]);
    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $promptmodel = Promptmodel::where('type', 'parent_model')
            ->where('status', 1)
            ->latest()->get();
        if (request()->has('prompt_id')) {
            $promptGroups = Promptmodel::where('promptmodel_id', request('prompt_id'))
                ->where('type', 'prompt_group')
                ->with('submodels')
                ->get();
            $promptCategory = Promptcategory::where('promptmodel_id', request('prompt_id'))->get();
        }
        $collections = Collection::where('user_id', auth()->id())->get();
        return Inertia::render('Frontend/Account/Prompt/Create', [
            'promptmodel' => $promptmodel,
            'promptGroups' => $promptGroups ?? [],
            'promptCategory' => $promptCategory ?? [],
            'collections' => $collections,
        ]);
    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $promptmodel = Promptmodel::where('type', 'parent_model')
            ->where('id', $request->prompt['promptmodel_id'])
            ->where('status', 1)
            ->firstOrFail();

        $request->validate([
            'prompt.preview' => 'nullable|image|max:5000',
            'prompt.title' => 'required|string|max:100',
            'prompt.layout_type' => 'required|string|max:100',
            'prompt.price' => 'required|numeric|min:1',
            'prompt.promptmodel_id' => 'required|exists:promptmodels,id',
            'prompt.collection_id' => 'nullable|exists:collections,id',
            'prompt.promptcategory_id' => 'required|exists:promptcategories,id',
            'prompt_details.prompt' => 'required|string',
            'prompt_details.prompt_instruction' => 'required|string',
            'prompt_details.image_width' => Rule::requiredIf($promptmodel->accept_image_size_measurement === 1),
            'prompt_details.image_height' => [Rule::requiredIf($promptmodel->accept_image_size_measurement)],
            'prompt_details.cfg_scale' => [Rule::requiredIf($promptmodel->accept_image_size_measurement)],
            'prompt_details.steps' => [Rule::requiredIf($promptmodel->accept_image_size_measurement)],
            'prompt_details.seed' =>  [Rule::requiredIf($promptmodel->accept_seed)],
            'prompt_details.profile_link' =>  [Rule::requiredIf($promptmodel->accept_profile_link)],
            'prompt_details.negative_prompt' =>  [Rule::requiredIf($promptmodel->accept_negative_prompt)],
        ], [
            'dimensions' => ':attribute must be max 500 x 500'
        ]);

        DB::beginTransaction();
        try {
            if ($request->hasFile('prompt.preview')) {
                $preview = $this->saveFile($request, 'prompt.preview');
            }

            if ($request->hasFile('prompt.gallery')) {
                $request->validate([
                    'prompt.gallery.*' => 'required|image|max:5000',
                ]);
                $gallery = $this->multipleSaveFile($request, 'prompt.gallery');
            }
            $isTitleUnique = Prompt::where('title', $request->prompt['title'])->count();
            $slug = Str::slug($request->prompt['title'] . $isTitleUnique > 0 ? $request->prompt['title'] . Str::random(2) : '');

            $prompt = Prompt::create([
                'user_id' => auth()->user()->id,
                'preview' => $preview ?? null,
                'gallery' => isset($gallery) ? json_encode($gallery) : null,
                'title' => $request->prompt['title'],
                'layout_type' => $request->prompt['layout_type'],
                'slug' => $slug,
                'type' => 'prompt',
                'price' => $request->prompt['price'],
                'promptmodel_id' => $request->prompt['promptmodel_id'],
                'promptcategory_id' => $request->prompt['promptcategory_id'],
                'collection_id' => $request->prompt['collection_id'],
                'meta' => json_encode($request->prompt['meta'])
            ]);
            if ($promptmodel->has_submodel) {
                $request->validate([
                    'prompt.submodels.*' => 'required|exists:promptmodels,id',
                ]);
                foreach ($request->prompt['submodels'] as $id) {
                    Promptmodelrelation::create([
                        'prompt_id' => $prompt->id,
                        'promptmodel_id' => $id
                    ]);
                }
            }

            Promptfile::create([
                'prompt_id' => $prompt->id,
                'files' => json_encode($request->prompt_details)
            ]);
            DB::commit();
            return back();
        } catch (\Throwable $th) {
            DB::rollback();

            return response()->json([
                'message' => $th->getMessage()
            ], 500);
        }
    }

   

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $prompt = Prompt::where('id', $id)
            ->where('status', 1)
            ->where('user_id', auth()->id())
            ->with('discount')
            ->firstOrFail();
        $promptmodel = Promptmodel::where('type', 'parent_model')
            ->where('status', 1)
            ->where('id', $prompt->promptmodel_id)->firstOrFail();

        $promptGroups = Promptmodel::where('promptmodel_id', $promptmodel->id)
            ->where('type', 'prompt_group')
            ->with('submodels')
            ->get();
        $promptCategory = Promptcategory::where('promptmodel_id', $promptmodel->id)->get();
        $promptcategoryimages = Promptcategoryimage::where('promptcategory_id', $prompt->promptcategory_id)->get();
        $promptFiles = Promptfile::where('prompt_id', $prompt->id)->first();

        $promptModelRelation = Promptmodelrelation::where('prompt_id', $prompt->id)->pluck('promptmodel_id');
        $collections = Collection::where('user_id', auth()->id())->get();
        return Inertia::render('Frontend/Account/Prompt/Edit', [
            'promptmodel' => $promptmodel,
            'prompt' => $prompt,
            'promptGroups' => $promptGroups ?? [],
            'promptCategory' => $promptCategory ?? [],
            'promptFiles' => $promptFiles,
            'promptcategoryimages' => $promptcategoryimages,
            'promptModelRelation' => $promptModelRelation,
            'collections' => $collections
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
      
        $prompt = Prompt::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $promptmodel = Promptmodel::where('type', 'parent_model')
            ->where('id', $request->prompt['promptmodel_id'])
            ->where('status', 1)
            ->firstOrFail();

        $request->validate([
            'prompt.title' => 'required|string|max:100',
            'prompt.price' => 'required|numeric|min:1',
            'prompt.promptmodel_id' => 'required|exists:promptmodels,id',
            'prompt.promptcategory_id' => 'required|exists:promptcategories,id',
            'prompt.collection_id' => 'nullable|exists:collections,id',
            'prompt_details.prompt' => 'required|string',
            'prompt_details.prompt_instruction' => 'required|string',
            'prompt_details.image_width' => Rule::requiredIf($promptmodel->accept_image_size_measurement === 1),
            'prompt_details.image_height' => [Rule::requiredIf($promptmodel->accept_image_size_measurement)],
            'prompt_details.cfg_scale' => [Rule::requiredIf($promptmodel->accept_image_size_measurement)],
            'prompt_details.steps' => [Rule::requiredIf($promptmodel->accept_image_size_measurement)],
            'prompt_details.seed' =>  [Rule::requiredIf($promptmodel->accept_seed)],
            'prompt_details.profile_link' =>  [Rule::requiredIf($promptmodel->accept_profile_link)],
            'prompt_details.negative_prompt' =>  [Rule::requiredIf($promptmodel->accept_negative_prompt)],
        ]);

        DB::transaction(function () use ($request, $prompt, $promptmodel) {
            if ($request->hasFile('prompt.preview')) {
                $request->validate([
                    'prompt.preview' => 'nullable|image|max:5000',
                ]);
                $preview = $this->saveFile($request, 'prompt.preview');
            }
            // gallery
            $existingGallery = json_decode($prompt->gallery, true);
            if ($request->has('prompt_details.deleteImgs') && is_array($request->prompt_details['deleteImgs']) && $prompt->gallery != null) {
                foreach ($request->prompt_details['deleteImgs'] as $key => $imageId) {
                    unset($existingGallery[$key]);
                    $this->removeFile($imageId);
                }
                $prompt->update([
                    'gallery' => json_encode(array_values($existingGallery)),
                ]);
                $existingGallery = array_values($existingGallery);
            }
            if ($request->hasFile('prompt.gallery')) {
                $request->validate([
                    'prompt_details.gallery.*' => 'required|image|max:5000',
                ]);
                $gallery = $this->multipleSaveFile($request, 'prompt.gallery');
                if ($promptmodel->accept_image === 1 && $prompt->gallery != null) {
                    $gallery = array_merge($existingGallery, $gallery);
                }
                $prompt->update([
                    'gallery' => json_encode($gallery),
                ]);
            }
            $price = $request->prompt['price'];
            if ($request->filled('discount.percentage') && $request->filled('discount.will_expire')) {
                if ($request->discount['remove']) {

                    $price = round($prompt->price / (1 - ($prompt->discount->percentage / 100)));
                    $prompt->discount()->delete();
                } else {
                    $request->validate([
                        'discount.percentage' => 'required|numeric',
                        'discount.will_expire' =>  'required|date|after:today',
                    ]);
                    Discount::query()->updateOrCreate(
                        [
                            'prompt_id' => $prompt->id,
                        ],
                        [
                            'percentage' => $request->discount['percentage'],
                            'will_expire' => $request->discount['will_expire']
                        ]
                    );

                    $discountAmount = round($prompt->price * ($request->discount['percentage'] / 100));
                    $price = $prompt->price - $discountAmount;
                }
            }
            if ($prompt->title != $request->prompt['title']) {
                $isTitleUnique = Prompt::where('title', $request->prompt['title'])->where('id', '!=', $prompt->id)->count();
                $slug = Str::slug($request->prompt['title'] . $isTitleUnique > 0 ? $request->prompt['title'] . Str::random(2) : '');
            }

            $prompt->update([
                'user_id' => auth()->user()->id,
                'preview' => $preview ?? $prompt->preview,
                'title' => $request->prompt['title'],
                'slug' => $slug ?? $prompt->slug,
                'type' => 'prompt',
                'price' => $price,
                'promptmodel_id' => $request->prompt['promptmodel_id'],
                'promptcategory_id' => $request->prompt['promptcategory_id'],
                'collection_id' => $request->prompt['collection_id'] ?? $prompt->collection_id,
                'meta' => json_encode($request->prompt['meta']),
                'layout_type' => $request->prompt['layout_type'] ?? $prompt->layout_type,
            ]);
            if ($promptmodel->has_submodel) {
                $request->validate([
                    'prompt.submodels.*' => 'required|exists:promptmodels,id',
                ]);
                Promptmodelrelation::where('prompt_id', $prompt->id)->delete();
                foreach ($request->prompt['submodels'] as $id) {
                    Promptmodelrelation::create([
                        'prompt_id' => $prompt->id,
                        'promptmodel_id' => $id
                    ]);
                }
            }
            Promptfile::where('prompt_id', $prompt->id)->first()->update([
                'files' => json_encode($request->prompt_details)
            ]);
        });
        return back();
    }

    /**
     * update the specified resource from storage.
     */
    public function updateStatus(string $id)
    {
        $prompt = Prompt::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $prompt->update([
            'status' => 0,
        ]);

        return back();
    }
}
