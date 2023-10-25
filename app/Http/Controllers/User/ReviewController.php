<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Orderitem;
use App\Models\Prompt;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ReviewController extends Controller
{
      /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        $request->validate([
            'comment' => 'required|string|max:255',
            'star' => 'required|integer|between:1,5',
        ]);
        $prompt = Prompt::findOrFail($request->prompt_id);
        $order = Orderitem::query()->where('prompt_id', $prompt->id)
                ->whereHas('order',function($q){
                    return $q->where('user_id',auth()->user()->id);
                });
        if (!$order->exists()) {
            return throw ValidationException::withMessages(['order' => 'You can not review this prompt']);
        }
        $review = Review::where('order_id',$order->first()->order_id)->first();
        if (empty($review)) {
           $review = new Review;
        }
        $review->order_id = $order->first()->order_id;
        $review->comment = $request->comment;
        $review->star = $request->star;
        $review->prompt_id = $prompt->id;
        $review->user_id = auth()->user()->id;
        $review->seller_id = $prompt->user_id;
        $review->status = 0;
        $review->save();

        return back();
    }

    
}
