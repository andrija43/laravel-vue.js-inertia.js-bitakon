<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Post;
use App\Models\Prompt;
use App\Models\Promptmodel;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeTwoController extends Controller
{

    /**
     * return the specified resource from storage.
     */
    public function index(Request $request)
    {
        $type = $request->type ?? 'trending';
        $data = [];
        if ($type === 'brands') {
            $data = Category::whereType('brand')->latest()->get();
        }
        if ($type === 'blog') {
            $data = Post::where('type', 'blog')->where('lang', app()->getLocale())
                ->with('preview', 'categories')->where('status', 1)->inRandomOrder()->take(2)->get();
        }
        if ($type === 'collection') {
            $data = Collection::where('status', 1)->where('is_featured', 1)
                ->withCount(['prompts' => function ($q) {
                    $q->where('status', 1);
                }])
                ->orderBy('prompts_count', $request->order ?? 'desc')
                ->take(12)->get();
        }
        if ($type === 'prompt') {
            $data['promptmodels'] = Promptmodel::query()->where('status', 1)
                ->where('type', 'parent_model')
                ->get();
            $data['prompts'] = Prompt::where('status', 1)
                ->with(['promptmodel:id,title,created_at', 'user:id,name,username,created_at,avatar'])
                ->when($request->model, function ($query) use ($request) {
                    $query->where('promptmodel_id', $request->model);
                })
                ->withCount(['likes as is_liked' => function ($query) {
                    $query->where('user_id', auth()->id());
                }])
                ->withAvg(['reviews' => function ($query) {
                    $query->where('status', 1);
                }], 'star')
                ->orderBy(request()->sort ?? 'created_at', request()->order ?? 'desc')->take(8)->get();
        }
        if ($type === 'top') {
            $data['discount'] = Prompt::where('status', 1)
                ->has('discount')
                ->with(['promptmodel:id,title,created_at', 'user:id,name,username,created_at,avatar', 'discount'])
                ->withCount(['likes as is_liked' => function ($query) {
                    $query->where('user_id', auth()->id());
                }])
                ->inRandomOrder()->first();
            $data['prompts'] = DB::table('orderitems')
                ->join('users', 'orderitems.user_id', '=', 'users.id')
                ->join('prompts', 'orderitems.prompt_id', '=', 'prompts.id')
                ->join('orders', 'orderitems.order_id', '=', 'orders.id')
                ->join('promptmodels', 'prompts.promptmodel_id', '=', 'promptmodels.id')
                ->selectRaw('prompts.*, users.name, users.avatar, promptmodels.title as model_title, sum(orderitems.id) as total_sold')
                ->whereNot('prompts.id', $data['discount']->id)
                ->groupBy('prompts.id', 'users.name')
                ->orderBy('total_sold', 'desc')
                ->take(6)
                ->get();
        }
        if ($type === 'slider') {
            $data = Prompt::query()
                ->select('id', 'title', 'slug', 'price', 'preview', 'meta', 'created_at', 'user_id', 'total_likes')
                ->has('slider')
                ->with([
                    'user:id,name,username,created_at,avatar'
                ])
                ->withCount(['likes as is_liked' => function ($query) {
                    $query->where('user_id', auth()->id());
                }])
                ->take(5)->get();
        }
        return response()->json($data);
    }
}
