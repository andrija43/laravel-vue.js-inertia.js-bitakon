<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Postmeta;
use App\Http\Requests\PageRequest;
use App\Actions\Page;
use DB;
use Auth;
use Cache;
use Inertia\Inertia;

class PageController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:custom-page');
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
                'name' => '<i class="fa fa-plus"></i>&nbsp' . __('Create a page'),
                'url' => route('admin.page.create'),
            ]
        ];
        $pages = Post::where('type', 'page')->orderBy('id', 'desc')->paginate(20);
        $totalActivePosts = Post::where('type', 'page')->where('status', 1)->count();
        $totalInActivePosts = Post::where('type', 'page')->where('status', 0)->count();
        $totalPosts = Post::where('type', 'page')->count();

        return Inertia::render('Admin/Page/Index', [
            'pages' => $pages,
            'totalActivePosts' => $totalActivePosts,
            'totalInActivePosts' => $totalInActivePosts,
            'totalPosts' => $totalPosts,
            'buttons' => $buttons,
            'segments' => $segments,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $segments = request()->segments();
        $buttons = [[
            'name' => __('Back'),
            'url' => route('admin.page.index'),
        ]];
        return Inertia::render('Admin/Page/Create', [
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
    public function store(PageRequest $request, Page $page)
    {
        $validated = $request->validated();

        DB::beginTransaction();
        try {

            $page = $page->create($request);

            DB::commit();
        } catch (Throwable $th) {
            DB::rollback();

            return response()->json([
                'message' => $th->getMessage()
            ], 500);
        }

        return to_route('admin.page.index');
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $segments = request()->segments();
        $buttons = [
            [
                'name' => __('Back'),
                'url' => route('admin.page.index'),
            ]
        ];
        $info = Post::with('description', 'seo')->findOrFail($id);
        $seo = json_decode($info->seo->value ?? '');


        return Inertia::render('Admin/Page/Edit', [
            'buttons' => $buttons,
            'segments' => $segments,
            'info' => $info,
            'seo' => $seo,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, Page $page)
    {
        $request->validate([
            'title' => 'required|max: 150',
            'description.value' => 'required|max:5000',
        ]);


        DB::beginTransaction();
        try {

            $page = $page->update($request, $id);

            DB::commit();

            return to_route('admin.page.index');
        } catch (Throwable $th) {
            DB::rollback();

            return response()->json([
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $page)
    {
        $page->delete();
        Cache::forget('page_' . $page->slug);

        return back();
    }
}
