<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReviewController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $segments = request()->segments();
        $buttons = [];
        $reviews = Review::query()->with(['user:id,name,created_at', 'prompt:id,title,slug,created_at'])
            ->latest()->paginate(10);
        $totalReviews = Review::query()->count();
        $activeReviews = Review::query()->where('status', 1)->count();
        $inactiveReviews = Review::query()->where('status', 0)->count();

        return Inertia::render('Admin/Review/Index', [
            'reviews' => $reviews,
            'buttons' => $buttons,
            'segments' => $segments,
            'totalReviews' => $totalReviews,
            'activeReviews' => $activeReviews,
            'inactiveReviews' => $inactiveReviews,
        ]);
    }

     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $review = Review::findOrFail($id);

        $request->validate([
            'comment' => 'required|string|max:255',
            'star' => 'required|integer|between:1,5',
        ]);

        $review->update([
            'comment' => $request->comment,
            'star' => $request->star,
            'status' => $request->status ?? $review->status,
        ]);

        return back();
    }

    public function destroy($id)
    {
        Review::findOrFail($id)->delete();
        return back();
    }
}
