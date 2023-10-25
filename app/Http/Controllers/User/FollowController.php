<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Follower;

class FollowController extends Controller
{

     /**
     * Display a listing of the resource.
     * @param   $request
     * @return \Illuminate\Http\Response
     */
    public function following(Request $request)
    {
        $isFollowing = Follower::where('user_id', $request->id)
            ->where('follower_id', auth()->id())
            ->first();

        if ($isFollowing) {
            $isFollowing->delete();
        } else {
            Follower::create([
                'user_id' => $request->id,
                'follower_id' => auth()->id(),
            ]);
        }

        return back();
    }
}
