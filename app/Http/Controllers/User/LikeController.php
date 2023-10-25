<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Prompt;
use App\Models\Promptlike;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $prompt = Prompt::findOrFail($request->id);
        $isLiked = Promptlike::where('prompt_id', $prompt->id)
            ->where('user_id', auth()->id())
            ->first();

        if ($isLiked) {
            $prompt->decrement('total_likes');
            $isLiked->delete();
        } else {
            $prompt->increment('total_likes');
            Promptlike::create([
                'prompt_id' => $request->id,
                'user_id' => auth()->id(),
            ]);
        }
    }
}
