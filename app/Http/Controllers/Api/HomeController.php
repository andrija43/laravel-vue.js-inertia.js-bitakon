<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use App\Models\Post;
use App\Models\Prompt;
use App\Models\Promptmodel;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * return the specified resource from storage.
     */
    public function index(Request $request)
    {
        $sort = $request->sort;
        $type = $request->type ?? 'seller';
        $data = [];
        if ($type === 'seller') {
            $data = DB::table('users')
                ->where('role','!=','admin')
                ->leftJoin('prompts', 'users.id', '=', 'prompts.user_id')
                ->leftJoin('orderitems', 'prompts.id', '=', 'orderitems.prompt_id')
                ->leftJoin('orders', 'orderitems.order_id', '=', 'orders.id')
                ->select('users.id', 'users.name', 'users.username', 'users.avatar', DB::raw('COUNT(orderitems.prompt_id) as total_sold'))
                ->when($sort === 'today', function ($q) {
                    $q->whereDate('orders.created_at', today());
                })
                ->when($sort === 'yesterday', function ($q) {
                    $q->whereDate('orders.created_at', now()->yesterday());
                })
                ->groupBy('users.id', 'users.name', 'users.username', 'users.avatar')
                ->orderByDesc('total_sold')
                ->take(6)
                ->get();
        }
        if ($type === 'prompt') {
            $auth_id = auth()->check() ? auth()->id() : null;
            $data = DB::table('orderitems')
                ->join('users', 'orderitems.user_id', '=', 'users.id')
                ->join('prompts', 'orderitems.prompt_id', '=', 'prompts.id')
                ->join('orders', 'orderitems.order_id', '=', 'orders.id')
                ->join('promptmodels', 'prompts.promptmodel_id', '=', 'promptmodels.id')
                ->leftJoin('reviews', 'prompts.id', '=', 'reviews.prompt_id')
                ->leftJoin('promptlikes', function ($join) use ($auth_id) {
                    $join->on('orderitems.prompt_id', '=', 'promptlikes.prompt_id')
                        ->where('promptlikes.user_id', $auth_id);
                })
                ->selectRaw('prompts.*, users.name, users.username, users.avatar, promptmodels.title as model_title,
                    sum(orderitems.id) as total_sold, avg(reviews.star) as reviews_avg_star,
                    IFNULL(MAX(promptlikes.user_id), 0) AS is_liked')
                ->groupBy('prompts.id', 'users.name')
                ->orderBy('total_sold', 'desc')
                ->take(10)
                ->get();
        }
        if ($type === 'explore') {
            if (!$request->filled('model_id')) {
                $data['models'] = Promptmodel::where('type', 'parent_model')
                    ->where('status', 1)->select('id', 'slug', 'title', 'preview', 'icon', 'created_at')
                    ->get();
            }
            $modelId = $request->model_id ?? $data['models']->first()->id;

            $data['prompts'] = Prompt::where('promptmodel_id', $modelId)
                ->where('status', 1)
                ->with(['promptmodel:id,title,created_at', 'user:id,name,username,created_at,avatar'])
                ->withCount(['likes as is_liked' => function ($query) {
                    $query->where('user_id', auth()->id());
                }])
                ->withAvg(['reviews' => function ($query) {
                    $query->where('status', 1);
                }], 'star')
                ->orderBy(request()->sort ?? 'created_at', request()->order ?? 'desc')->take(8)->get();
        }

        if ($type === 'collection') {
            $data = Collection::where('status', 1)->where('is_featured', 1)
                ->with(['prompt_previews', 'user:id,name,avatar,created_at'])
                ->whereHas('prompts', function ($q) {
                    return $q->where('status', 1);
                })
                ->withCount(['prompts' => function ($q) {
                    $q->where('status', 1);
                }])
                ->take(3)->get();
        }
        if ($type === 'features') {
            $data = Post::where('type', 'feature')->where('lang', current_locale())->with('excerpt', 'preview')->latest()->take(4)->get();
        }
        if ($type === 'slider') {
            $sliders = Slider::query()
                ->with('prompt:id,title,price,preview,meta,slug,created_at')
                ->orderByDesc('updated_at')
                ->where('status', 1)->take(21)->get()->toArray();

            $slidersChunks = array_chunk($sliders, 7);

            $data = array_filter($slidersChunks, function ($chunk) {
                return count($chunk) > 6;
            });
        }
        return response()->json($data);
    }
}
