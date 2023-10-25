<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Option;
use App\Traits\Uploader;
use Cache;
use Inertia\Inertia;

class AboutController extends Controller
{
    use Uploader;

    public function __construct()
    {
        $this->middleware('permission:about');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $languages = get_option('languages', true);

        $about =  get_option('about', true, true);
        $current_lang = app()->getLocale();

        $segments = request()->segments();
        $buttons = [];

        return  Inertia::render('Admin/About/Index', compact('languages', 'segments', 'buttons', 'about', 'current_lang'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $about = Option::where('key', 'about')->where('lang', $request->lang)->first();
        if (empty($about)) {
            $about = new Option;
            $about->key = 'about';
            $about->lang = $request->lang;
        }

        $about_us =  get_option('about', true, true);

        $data['breadcrumb_title'] = $request->breadcrumb_title;
        $data['breadcrumb_description'] = $request->breadcrumb_description;
        $data['marquee'] = $request->marquee;
        $data['description'] = $request->description;
        $data['launching'] = $request->launching;
        $data['users'] = $request->users;
        $data['employees'] = $request->employees;
        $data['collections'] = $request->collections;
        $data['prompts'] = $request->prompts;
        $data['volume'] = $request->volume;
        $data['button_title'] = $request->button_title;
        $data['button_link'] = $request->button_link;
        $data['facilities'] = $request->facilities;
        $data['introducing_video'] = $request->introducing_video;

        if ($request->hasFile('about_images')) {
            $request->validate([
                'about_images.*' => 'required|image|max:5000',
            ]);
            $gallery = $this->multipleSaveFile($request, 'about_images');
            $data['about_images'] = json_encode($gallery);
        }

        $about->value = json_encode($data);
        $about->save();

        Cache::flush();

        return back();
    }
}
