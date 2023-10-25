<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use Validator;
use Cache;
use Auth;
use Inertia\Inertia;

class MenuController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:menu');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menus = Menu::latest()->get();
        $languages = get_option('languages', true);

        $totalMenus =  Menu::count();
        $totalActiveMenus =  Menu::where('status', 1)->count();
        $totalDraftMenus =  Menu::where('status', 0)->count();

        $segments = request()->segments();

        $buttons = [
            [
                'name' => '<i class="fa fa-plus"></i>&nbsp' . __('Create Menu'),
                'url' => '#',
                'target' => '#addRecord',
            ]
        ];

        return Inertia::render('Admin/Menu/Index', compact('menus', 'languages', 'totalMenus', 'totalActiveMenus', 'totalDraftMenus', 'segments', 'buttons'));
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'  => ['required'],
            'position' => ['required'],
            'status' => ['required'],
            'status' => ['required'],
            'language' => ['required'],
        ]);

        if ($request->status == 1) {
            Menu::where('position', $request->position)
                ->where('lang', $request->lang)
                ->update(['status' => 0]);
        }

        $men = new Menu;
        $men->name = $request->name;
        $men->position = $request->position;
        $men->status = $request->status;
        $men->lang = $request->language;
        $men->data = "[]";
        $men->save();

        return back();
    }

    public function updateData($id, Request $request)
    {
        $info = Menu::findOrFail($id);
        $info->data = json_encode($request->data);
        $info->save();

        Cache::forget('menu_' . $info->lang);
        return response()->json([
            'message'  => __('Menu Updated Successfully.')
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $info = Menu::findOrFail($id);
        $contents = json_decode($info->data) ?? '';

        $segments = request()->segments();

        $buttons = [
            [
                'name' => __('Back'),
                'url' => route('admin.menu.index')
            ]
        ];

        return Inertia::render('Admin/Menu/Show', compact('info', 'contents', 'segments', 'buttons'));
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
        $request->validate([
            'name'  => 'required',
            'position' => 'required',
            'status' => 'required',
            'status' => 'required',
            'language' => 'required',
        ]);

        if ($request->status == 1) {
            Menu::where('position', $request->position)
                ->where('lang', $request->lang)
                ->update(['status' => 0]);
        }

        $menu = Menu::find($id);
        $menu->name = $request->name;
        $menu->position = $request->position;
        $menu->status = $request->status;
        $menu->lang = $request->language;
        $menu->save();

        Cache::forget($request->position . $request->language);

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
        $menu = Menu::findOrFail($id);
        $menu->delete();

        return back();
    }
}
