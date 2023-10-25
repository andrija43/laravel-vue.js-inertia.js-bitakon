<?php

namespace App\Http\Controllers\Admin;

use Throwable;
use App\Models\Post;
use Illuminate\Support\str;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Postmeta;
use Illuminate\Support\Facades\Artisan;
use App\Traits\Uploader;
use App\Http\Requests\BlogRequest;
use App\Actions\Blog;
use Inertia\Inertia;

class BlogController extends Controller
{
    use Uploader;

    public function __construct()
    {
        $this->middleware('permission:blogs');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $segments = request()->segments();
        $posts = Post::query();
        $buttons = [[
            'name' => '<i class="fa fa-plus"></i>&nbsp' . __('Create a blog post'),
            'url' => route('admin.blog.create'),
        ]];
        if (!empty($request->search)) {
            $posts = $posts->where('title', 'LIKE', '%' . $request->search . '%');
        }
        $posts = $posts->with('preview')
            ->where('type', 'blog')
            ->latest()
            ->paginate(20);

        $type = $request->type ?? '';

        $totalPosts = Post::query()->where('type', 'blog')->count();
        $totalActivePosts = Post::query()->where('type', 'blog')->where('status', 1)->count();
        $totalInActivePosts = Post::query()->where('type', 'blog')->where('status', 0)->count();

        return Inertia::render(
            'Admin/Blog/Index',
            [
                'posts' => $posts,
                'totalPosts' => $totalPosts,
                'totalActivePosts' => $totalActivePosts,
                'totalInActivePosts' => $totalInActivePosts,
                'buttons' => $buttons,
                'segments' => $segments,
                'type' => $type,
                'request' => $request,
            ]
        );
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
            'url' => route('admin.blog.index'),
        ]];
        $tags = Category::whereType('tags')->pluck('title', 'id');
        $categories = Category::whereType('blog_category')->where('status', 1)->pluck('title', 'id');
        $languages = get_option('languages', true);

        return Inertia::render('Admin/Blog/Create', [
            'tags' => $tags,
            'categories' => $categories,
            'languages' => $languages,
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
    public function store(BlogRequest $request, Blog $blog)
    {
        $request->validated();

        DB::beginTransaction();
        try {

            $blog = $blog->create($request);

            DB::commit();

            return redirect()->route('admin.blog.index')->with('success', __('Blog post created successfully'));
        } catch (Throwable $th) {
            DB::rollback();

            return response()->json([
                'message' => $th->getMessage()
            ], 500);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $segments = request()->segments();
        $buttons = [[
            'name' => __('Back'),
            'url' => route('admin.blog.index'),
        ]];
        $info = Post::where('type', 'blog')->with('postcategories', 'preview', 'seo', 'shortDescription', 'longDescription', 'seo')->findOrFail($id);
        $tags = Category::whereType('tags')->get(['title', 'id']);
        $categories = Category::whereType('blog_category')->get(['title', 'id']);

        $tagsArr = [];
        $cats = [];

        foreach ($info->postcategories as $key => $cat) {
            $category_id = $cat->category_id;

            $tagExists = $tags->where('id', $category_id)->first();

            $categoryExists = $categories->where('id', $category_id)->first();

            if ($tagExists) {
                array_push($tagsArr, $category_id);
            }

            if ($categoryExists) {
                array_push($cats, $category_id);
            }
        }


        $seo = json_decode($info->seo->value ?? '');
        $languages = get_option('languages', true);

        return Inertia::render('Admin/Blog/Edit', [
            'info' => $info,
            'tags' => $tags,
            'categories' => $categories,
            'cats' => $cats,
            'tagsArr' => $tagsArr,
            'seo' => $seo,
            'languages' => $languages,
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
    public function update($id, Blog $blog)
    {
        request()->validate([
            'blog.title' => ['required', 'string', 'max:150'],
            'blog.preview' => ['nullable', 'image', 'max:1024'],
            'blog.meta_image' => ['nullable', 'image', 'max:1024'],
            'blog.short_description' => ['required', 'max:500'],
            'blog.main_description' => ['required', 'max:5000'],
            'blog.meta_title' =>  ['required', 'max:200'],
            'blog.meta_description' =>  ['max:1000'],
            'blog.meta_tags' =>  ['max:200'],
        ]);

        DB::beginTransaction();
        try {

            $blog = $blog->update(request()->blog, $id);

            DB::commit();

            return to_route('admin.blog.index');
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
    public function destroy(Post $blog)
    {
        if (!empty($blog->preview)) {
            $this->removeFile($blog->preview->value);
        }
        if (!empty($blog->seo)) {
            $seo = json_decode($blog->seo->value);
            if (!empty($seo->image ?? '')) {
                $this->removeFile($seo->image);
            }
        }

        $blog->delete();

        Artisan::call('cache:clear');

        return redirect()->route('admin.blog.index')->with('success', __('Blog post deleted successfully'));
    }

    public function massDestroy(Request $request)
    {
        $request->validate([
            'id' => ['required', 'array']
        ]);

        Post::whereIn('id', $request->input('id'))->delete();

        return response()->json([
            'message' => __('Blog Posts Deleted Successfully'),
            'redirect' => route('admin.blog.index')
        ]);
    }
}
