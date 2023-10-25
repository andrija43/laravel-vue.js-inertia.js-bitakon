<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Orderitem;
use App\Models\Prompt;
use App\Models\Review;
use App\Models\Visitor;

class PromptController extends Controller
{

    /**
     * return resources from storage.
     */
    public function index()
    {
        $data = [];
        $prompt = Prompt::where('id', request()->id)
            ->where('status', 1)
            ->firstOrFail();
        $visitedPrompts = request()->session()->get('visitedPrompts', []);
        if (!in_array(request()->id, $visitedPrompts)) {
            $visitedPrompts[] = $prompt->id;
            Visitor::create([
                'prompt_id' => $prompt->id,
                'ip_address' => request()->ip(),
                'user_id' => auth()->check() ? auth()->id() : null,
            ]);
            $prompt->increment('total_views');
            request()->session()->put('visitedPrompts', $visitedPrompts);
        }

        $data['canReview'] = false;
        if (auth()->check()) {
            $order = Orderitem::query()->where('prompt_id', $prompt->id)
                ->whereHas('order', function ($q) {
                    return $q->where('user_id', auth()->user()->id);
                });
            if ($order->exists()) {
                $data['canReview'] = true;
            }
            $review = Review::query()->where('prompt_id', $prompt->id)
                ->where('user_id', auth()->id())
                ->where('status', 1);
            if ($review->exists()) {
                $data['canReview'] = false;
            }
        }
        $data['similar_prompts'] = Prompt::where('user_id', request()->user_id)
            ->where('status', 1)
            ->whereNot('id', request()->id)
            ->with(['promptmodel:id,title,created_at', 'user:id,name,username,created_at,avatar'])
            ->withCount(['likes as is_liked' => function ($query) {
                $query->where('user_id', auth()->id());
            }])
            ->latest()->take(8)->get();

        return response()->json($data);
    }

    public function filter_prompts()
    {
        $prompts = Prompt::where('status', 1)
            ->with(['promptmodel:id,title,created_at', 'user:id,name,username,created_at,avatar'])
            ->withCount(['likes as is_liked'])
            ->orderBy(request()->sort ?? 'created_at', request()->order ?? 'desc')
            ->paginate();
        return response()->json($prompts);
    }

    public function reviews()
    {
        $prompt = Prompt::where('id', request()->id)
            ->where('status', 1)
            ->firstOrFail();
        $reviews = Review::query()->where('prompt_id', $prompt->id)
            ->where('status', 1)
            ->with(['user:id,name,username,created_at,avatar'])
            ->paginate(1);
        return response()->json($reviews);
    }
}
