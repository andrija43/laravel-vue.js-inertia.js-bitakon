<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;
use App\Traits\Notifications;
use App\Models\User;
use Auth;
use Inertia\Inertia;

class NotifyController extends Controller
{

    use Notifications;

    public function __construct()
    {
        $this->middleware('permission:notification');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $segments = request()->segments();
        $buttons = [
            [
                'name' => '<i class="fa fa-plus"></i>&nbsp' . __('Create Notification'),
                'url' => '#',
                'target' => '#addRecord',
                'is_button' => true
            ]
        ];

        $notifications = Notification::query();

        if (!empty($request->search)) {
            if ($request->type == 'email') {
                $notifications = $notifications->whereHas('user', function ($q) use ($request) {
                    return $q->where('email', $request->search);
                });
            } else {
                $notifications = $notifications->where($request->type, 'LIKE', '%' . $request->search . '%');
            }
        }

        $notifications = $notifications->with('user')->latest()->paginate(30);
        $type = $request->type ?? 'email';

        $totalNotifications = Notification::count();
        $readNotifications  = Notification::where('seen', 1)->count();
        $unreadNotifications = Notification::where('seen', 0)->count();

        return Inertia::render('Admin/Logs/Notification/Index', [
            'notifications' => $notifications,
            'request' => $request,
            'type' => $type,
            'totalNotifications' => $totalNotifications,
            'readNotifications' => $readNotifications,
            'unreadNotifications' => $unreadNotifications,
            'buttons' => $buttons,
            'segments' => $segments,
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:100',
            'email' => 'required|email',
            'description'  => 'required',
            'url'  => 'required',

        ]);

        $user = User::where('email', $request->email)->first();
        if (empty($user)) {
            return response()->json([
                'message'  => __('User is not exist')
            ], 401);
        }

        $title = $request->title;
        $notification['user_id']   = $user->id;
        $notification['title']     = $title;
        $notification['comment']   = $request->description;
        $notification['url']       = $request->url;

        $this->createNotification($notification);

        return redirect()->back();
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $row = Notification::findOrFail($id);
        $row->delete();

        return redirect()->back();
    }
}
