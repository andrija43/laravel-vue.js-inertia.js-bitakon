<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use App\Models\Follower;
use App\Models\Prompt;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProfileController extends Controller
{

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($username)
    {
        $profile = User::where('username', $username)->where('status', 1)->firstOrFail();
        $prompts = Prompt::query()
            ->where('user_id', $profile->id)
            ->where('status', 1)
            ->with(['promptmodel:id,title,created_at', 'user:id,username,avatar,name,created_at'])
            ->withCount(['likes as is_liked' => function ($query) {
                $query->where('user_id', auth()->id());
            }])
            ->withAvg('reviews', 'star')
            ->latest()->paginate();

        $isFollowing = Follower::where('user_id', $profile->id)
            ->where('follower_id', auth()->id())
            ->exists();
        $followers = Follower::where('user_id', $profile->id)->count();
        $followings = Follower::where('follower_id', $profile->id)->count();

        $bio = json_decode($profile->meta);

        $meta['title'] = $profile->name ?? '';
        $meta['site_name'] = $profile->name ?? '';
        $meta['description'] = $bio->bio ?? '';
        $meta['preview'] = asset($profile->avatar ?? '');

        config()->set('seotools.metaDescription',$meta['description']);
        config()->set('seotools.site_name',$meta['title']);
        config()->set('seotools.current_url', url()->current());
        config()->set('seotools.metaImage',$meta['preview']);

        return Inertia::render('Frontend/Profile/Index', [
            'profile' => $profile,
            'isFollowing' => $isFollowing,
            'followers' => $followers,
            'followings' => $followings,
            'prompts' => $prompts,
            'seo' => $meta,
        ]);
    }

     /**
     * Display the specified resource.
     *
     * @param  string  $username
     * @return \Illuminate\Http\Response
     */
    public function collection($username)
    {
        $profile = User::where('username', $username)->where('status',1)->firstOrFail();
        $isFollowing = Follower::where('user_id', $profile->id)
            ->where('follower_id', auth()->id())
            ->exists();
        $followers = Follower::where('user_id', $profile->id)->count();
        $followings = Follower::where('follower_id', $profile->id)->count();
        $collections = Collection::where('user_id', $profile->id)
            ->with('prompt_previews')
            ->withCount('prompts')
            ->paginate();
        
        $bio = json_decode($profile->meta);

            $meta['title'] = 'Collections - '. $profile->name ?? '';
            $meta['site_name'] ='Collections - '. $profile->name ?? '';
            $meta['description'] = $bio->bio ?? '';
            $meta['preview'] = asset($profile->avatar ?? '');
    
            config()->set('seotools.metaDescription',$meta['description']);
            config()->set('seotools.site_name',$meta['title']);
            config()->set('seotools.current_url', url()->current());
            config()->set('seotools.metaImage',$meta['preview']);

        return Inertia::render('Frontend/Profile/Collection/Index', [
            'collections' => $collections,
            'profile' => $profile,
            'isFollowing' => $isFollowing,
            'followers' => $followers,
            'followings' => $followings,
            'seo' => $meta,
        ]);
    }

     /**
     * Display the specified resource.
     *
     * @param  string  $username
     * @return \Illuminate\Http\Response
     */
    public function followers($username)
    {
        $profile = User::where('username', $username)->where('status',1)->firstOrFail();
        $isFollowing = Follower::where('user_id', $profile->id)
            ->where('follower_id', auth()->id())
            ->exists();
        $followers = Follower::where('user_id', $profile->id)->count();
        $followings = Follower::where('follower_id', $profile->id)->count();
        $all_followers = Follower::where('user_id', $profile->id)->with('follower')->paginate(12);

        $bio = json_decode($profile->meta);

        $meta['title'] = 'Followers - '. $profile->name ?? '';
        $meta['site_name'] ='Followers - '. $profile->name ?? '';
        $meta['description'] = $bio->bio ?? '';
        $meta['preview'] = asset($profile->avatar ?? '');

        config()->set('seotools.metaDescription',$meta['description']);
        config()->set('seotools.site_name',$meta['title']);
        config()->set('seotools.current_url', url()->current());
        config()->set('seotools.metaImage',$meta['preview']);


        return Inertia::render('Frontend/Profile/Follower/Index', [
            'followers' => $followers,
            'profile' => $profile,
            'isFollowing' => $isFollowing,
            'followers' => $followers,
            'followings' => $followings,
            'all_followers' => $all_followers,
            'seo' => $meta,
        ]);
    }

     /**
     * Display the specified resource.
     *
     * @param  string  $username
     * @return \Illuminate\Http\Response
     */
    public function followings($username)
    {
        $profile = User::where('username', $username)->where('status',1)->firstOrFail();
        $isFollowing = Follower::where('user_id', $profile->id)
            ->where('follower_id', auth()->id())
            ->exists();
        $followers = Follower::where('user_id', $profile->id)->count();
        $followings = Follower::where('follower_id', $profile->id)->count();
        $all_followings = Follower::where('follower_id', $profile->id)->with('user')->paginate(12);

        $meta['title'] = 'Following - '. $profile->name ?? '';
        $meta['site_name'] ='Following - '. $profile->name ?? '';
        $meta['description'] = $bio->bio ?? '';
        $meta['preview'] = asset($profile->avatar ?? '');

        config()->set('seotools.metaDescription',$meta['description']);
        config()->set('seotools.site_name',$meta['title']);
        config()->set('seotools.current_url', url()->current());
        config()->set('seotools.metaImage',$meta['preview']);

        return Inertia::render('Frontend/Profile/Following/Index', [
            'followings' => $followings,
            'profile' => $profile,
            'isFollowing' => $isFollowing,
            'followers' => $followers,
            'followings' => $followings,
            'all_followings' => $all_followings,
            'seo' => $meta,
        ]);
    }
}
