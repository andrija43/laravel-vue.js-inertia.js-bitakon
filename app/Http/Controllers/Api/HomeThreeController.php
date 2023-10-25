<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use App\Models\Post;
use App\Models\Prompt;
use App\Models\Promptcategory;
use App\Models\Promptmodel;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeThreeController extends Controller
{

    /**
     * return the specified resource from storage.
     */
    public function index(Request $request)
    {
        $type = $request->type ?? 'trending';
        $data = [];
        if ($type === 'trending') {
            $promptmodels = Promptmodel::where('status', 1)
                ->where('type', 'parent_model')
                ->select('id', 'title', 'slug', 'created_at')->get();

            $promptsQuery = Prompt::where('status', 1)
                ->when(request()->filled('s_query'), function ($query) {
                    $query->where('title', 'like', '%' . request()->s_query . '%');
                })
                ->with(['promptmodel:id,title,created_at', 'user:id,name,username,created_at,avatar'])
                ->withCount(['likes as is_liked' => function ($query) {
                    $query->where('user_id', auth()->id());
                }])
                ->withAvg(['reviews' => function ($query) {
                    $query->where('status', 1);
                }], 'star');
            $categories = [];
            if (request()->filled('model')) {
                $promptsQuery->whereHas('promptmodel', function ($query) {
                    $query->where('slug', request()->model);
                });
                $categories = Promptcategory::select('id', 'name', 'slug', 'created_at')
                    ->whereHas('promptmodel', function ($query) {
                        $query->where('slug', request()->model);;
                    })->get();
            }

            if (request()->filled('category')) {
                $promptsQuery->whereHas('category', function ($query) {
                    $query->where('slug', request()->category);
                });
            }
            if (request()->filled('rating')) {
                $promptsQuery->whereHas('reviews', function ($query) {
                    $query->where('star', request()->rating);
                });
            }
            $prompts = $promptsQuery->orderByDesc('created_at')
                ->take(6)->get();

            $data = [
                'prompts' => $prompts,
                'promptmodels' => $promptmodels,
                'categories' => $categories,
                'searchQuery' => request()->s_query,
            ];
        }
        if ($type === 'creator') {
            $data = DB::table('users')
                ->where('role','!=','admin')
                ->join('prompts', 'users.id', '=', 'prompts.user_id')
                ->join('orderitems', 'prompts.id', '=', 'orderitems.prompt_id')
                ->join('orders', 'orderitems.order_id', '=', 'orders.id')
                ->select('users.id', 'users.name', 'users.username', 'users.avatar', DB::raw('COUNT(orderitems.prompt_id) as total_sold'))
                ->whereBetween('orders.created_at', [now()->subDays(7)->format('Y-m-d')." 00:00:00", today()->format('Y-m-d')." 23:59:59"])
                ->groupBy('users.id')
                ->orderByDesc('total_sold')
                ->take(9)
                ->get();
        }
        if ($type === 'collection') {
            $data = Collection::where('status', 1)->where('is_featured', 1)
                ->with(['prompt_previews', 'user:id,name,username,avatar,created_at'])
                ->whereHas('prompts', function ($q) {
                    return $q->where('status', 1);
                })
                ->withCount('prompts')
                ->inRandomOrder()
                ->take(3)->get();
        }
        if ($type === 'process') {
            $data = Post::where('type', 'feature')->with('excerpt', 'preview')->latest()->take(4)->get();
        }
        if ($type === 'slider') {
            $sliders = Slider::query()
                ->with(['prompt:id,title,slug,price,preview,meta,created_at,user_id', 'prompt.user:id,name,username,created_at,avatar'])
                ->orderByDesc('updated_at')
                ->where('status', 1)->take(15)->get()->toArray();

            $slidersChunks = array_chunk($sliders, 3);

            $data = array_filter($slidersChunks, function ($chunk) {
                return count($chunk) > 2;
            });
        }
        return response()->json($data);
    }
}
