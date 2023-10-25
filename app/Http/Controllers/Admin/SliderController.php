<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prompt;
use Illuminate\Http\Request;
use App\Traits\Uploader;
use App\Models\Slider;
use Inertia\Inertia;

class SliderController extends Controller
{

    use Uploader;

    public function __construct()
    {
        $this->middleware('permission:page-settings');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $type = $request->type ?? 'title';
        $segments = request()->segments();
        $buttons = [];
        $sliders = Prompt::query();
        if (!empty($request->search)) {
            if ($request->type === 'title') {
                $sliders = $sliders->where($request->type, 'LIKE', '%' . $request->search . '%');
            }
        }
        $sliders = $sliders->with('slider')
            ->when($request->type === 'status', function ($q) {
                $q->has('slider');
            })
            ->latest()->paginate(12);
        $activeSliders = Slider::where('status', 1)->count();
        $inactiveSliders = Slider::where('status', 0)->count();
        $totalSliders = Slider::count();

        return Inertia::render('Admin/Slider/Index', [
            'segments' => $segments,
            'buttons' => $buttons,
            'sliders' => $sliders,
            'activeSliders' => $activeSliders,
            'inactiveSliders' => $inactiveSliders,
            'totalSliders' => $totalSliders,
            'request' => $request,
            'type' => $type,
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
        $request->validate([
            'prompt_id' => 'required|exists:prompts,id|numeric',
        ]);
        $findSlider = Slider::where('prompt_id', $request->prompt_id);
        if ($findSlider->exists() && $request->status == 0) {
            $findSlider->delete();
            return redirect()->route('admin.slider.index');
        }
        Slider::create([
            'prompt_id' => $request->prompt_id,
            'status' => 1,
        ]);

        return redirect()->route('admin.slider.index');
    }
}
