<?php

namespace App\Http\Middleware;

use App\Models\Follower;
use App\Models\Menu;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Inertia\Middleware;
use Session;
class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    // protected $rootView = 'app';


    public function rootView(Request $request)
    {
        $path = $request->segments();
        $path = $path[0] ?? 'frontend';

        if ($path == 'admin') {
            return 'layouts.admin.app';
        } elseif ($path == 'user') {
            return 'layouts.user.app';
        } else {
            return 'layouts.frontend.app';
        }

        return parent::rootView($request);
    }

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request): array
    {
        if (request()->is('install/*') || !file_exists(base_path('public/uploads/installed'))) {
            return [];
        }
        if (auth()->check() && request()->is('user/*')) {
            $notifications = Notification::where('user_id', auth()->id())->orderBy('seen', 'DESC')->where('seen', 0)->latest()->take(5)->get()->map(function ($query) {
                $data['url'] = url('user/notifications', $query->id);
                $data['title'] = $query->title;
                $data['comment'] = $query->comment;
                $data['created_at'] = $query->created_at->diffForHumans();

                return $data;
            });
            $data['list'] = $notifications;
            $data['unread'] = Notification::where('user_id', auth()->id())->where('seen', 0)->count();
        }
        $user = auth()->user();
        if (auth()->check() && request()->is('account', 'account/*')) {
            $followers = Follower::where('user_id', $user->id)->count();
            $followings = Follower::where('follower_id', $user->id)->count();
            $user = collect($user)->merge(['followers' => $followers, 'followings' => $followings]);
        }



        $locale = Session::get('locale', env('DEFAULT_LANG','en'));
        
        $menu = Cache::remember(
            'menu_' . $locale,
            env('CACHE_LIFETIME', 1800),
            function () use ($locale) {
                return Menu::where('status', 1)->where('lang', $locale)->oldest()->get();
            }
        );
       

        $primaryData = get_option('primary_data', true);
        $app_name = Cache::remember(
            'app_name_' . $locale,
            env('CACHE_LIFETIME', 1800),
            function () {
                return env('APP_NAME', 'Laravel');
            }
        );
        return array_merge(parent::share($request), [
            'auth' => [
                'isLoggedIn' => auth()->check(),
                'csrf' => csrf_token(),
                'flash' =>  session('flash'),
            ],
            'user' =>   auth()->check() ? $user : null,
            'notifications' => $data ?? null,
            'languages' => get_option('languages', true),
            'currency' => get_option('base_currency', true),
            'cartItems' =>  count($request->session()->get('cart', [])),
            'menus' => $menu,
            'primaryData' => $primaryData,
            'app_name' => $app_name,
            'footerData' => get_option('header_footer', true),
        ]);
    }
}
