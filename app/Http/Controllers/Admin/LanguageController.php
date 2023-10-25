<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Option;
use Cache;
use Auth;
use File;
use Inertia\Inertia;

class LanguageController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:language');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $segments = request()->segments();
        $buttons = [
            [
                'name' => '<i class="fa fa-plus"></i>&nbsp' . __('Create a language'),
                'url' => '#',
                'components' => 'data-toggle="modal" data-target="#addRecord" id="add_record"',
                'is_button' => true,
                'target' => '#addRecord',
            ]
        ];
        $languages = get_option('languages', true);
        $countries = base_path('lang/langlist.json');
        $countries = json_decode(file_get_contents($countries), true);

        return Inertia::render('Admin/Language/Index', [
            'languages' => $languages,
            'countries' => $countries,
            'buttons' => $buttons,
            'segments' => $segments,
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
        $file = base_path('lang/default.json');
        $file = file_get_contents($file);
        File::put(base_path('lang/' . $request->language_code . '.json'), $file);
        $languages = get_option('languages', true);

        $arr = [];
        if (!empty($languages)) {
            foreach ($languages as $key => $value) {
                $arr[$key] = $value;
            }
        }

        $arr[$request->language_code] = $request->name;

        $langlist = Option::where('key', 'languages')->first();
        if (empty($langlist)) {
            $langlist = new Option;
            $langlist->key = 'languages';
        }
        $langlist->value = json_encode($arr);
        $langlist->save();
        Cache::forget('languages');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $segments = request()->segments();
        $buttons = [
            [
                'name' => '<i class="fa fa-plus"></i>&nbsp' . __('Add Translation Key'),
                'url' => '#',
                'components' => 'data-toggle="modal" data-target="#addRecord" id="add_record"',
                'is_button' => true,
                'target' => '#addRecord',
            ],
            [
                'name' => __('Back'),
                'url' => route('admin.language.index'),
            ]
        ];
        $file = base_path('lang/' . $id . '.json');
        $posts = file_get_contents($file);
        $posts = json_decode($posts);

        return Inertia::render('Admin/Language/Show', [
            'posts' => $posts,
            'id' => $id,
            'buttons' => $buttons,
            'segments' => $segments,
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = [];
        foreach ($request->values as $key => $row) {
            $data[$key] = $row;
        }

        $file = json_encode($data, JSON_PRETTY_PRINT);
        File::put(base_path('lang/' . $id . '.json'), $file);

        return back();
    }

    public function addKey(Request $request)
    {
        // dd(request()->all());
        $request->validate([
            'key'  => 'required',
            'value' => 'required',
        ]);

        $file = base_path('lang/' . $request->id . '.json');
        $posts = file_get_contents($file);
        $posts = json_decode($posts);
        foreach ($posts as $key => $row) {
            $data[$key] = $row;
        }
        $data[$request->key] = $request->value;

        File::put(base_path('lang/' . $request->id . '.json'), json_encode($data, JSON_PRETTY_PRINT));

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $posts = Option::where('key', 'languages')->first();
        $languages = json_decode($posts->value);

        $data = [];
        foreach ($languages as $key => $row) {
            if ($id != $key) {
                $data[$key] = $row;
            }
        }

        $posts->value = json_encode($data);
        $posts->save();

        if (file_exists(base_path('lang/' . $id . '.json'))) {
            unlink(base_path('lang/' . $id . '.json'));
        }

        Cache::forget('languages');

        return back();
    }
}
