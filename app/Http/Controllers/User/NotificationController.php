<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;
use Auth;
use Inertia\Inertia;

class NotificationController extends Controller
{

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notifications = Notification::where('user_id', Auth::id())->latest()->paginate(30);

        return Inertia::render('Frontend/Dashboard/Notification/Index', [
            'notifications' => $notifications,
        ]);
    }


    /**
     * update resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $notification = Notification::where('user_id', Auth::id())->findOrFail($id);
        $notification->seen = 1;
        $notification->save();
        return back();
    }
}
