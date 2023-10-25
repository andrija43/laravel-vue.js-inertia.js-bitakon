<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Support;
use Inertia\Inertia;

class SupportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $segments = request()->segments();
        $buttons = [
            [
                'name' => '<i class="fa fa-plus"></i>&nbsp' . __('Create Support Request'),
                'url' => route('user.support.create'),
            ]
        ];
        $supports = Support::where('user_id', Auth::id())->latest()->withCount('conversations')->paginate(20);
        $openSupport = Support::where('user_id', Auth::id())->where('status', 1)->count();
        $pendingSupport = Support::where('user_id', Auth::id())->where('status', 2)->count();
        $total = Support::where('user_id', Auth::id())->count();

        return Inertia::render('User/Support/Index', [
            'supports' => $supports,
            'openSupport' => $openSupport,
            'pendingSupport' => $pendingSupport,
            'total' => $total,
            'buttons' => $buttons,
            'segments' => $segments,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $segments = request()->segments();
        $buttons = [
            [
                'name' => 'Back',
                'url' => route('user.support.index'),
            ]
        ];

        return Inertia::render('User/Support/Create', [
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
            'subject' => 'required|max:100|min:10',
            'message' => 'required|max:1000',
        ]);

        $support = new Support;
        $support->user_id = Auth::id();
        $support->subject = $request->subject;
        $support->save();

        $support->conversations()->create([
            'comment'  => $request->message,
            'is_admin' => 0,
            'user_id'  => Auth::id()
        ]);

        return to_route(route('user.support.show', $support->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $segments = request()->segments();
        $buttons = [
            [
                'name' => '<i class="fa fa-plus"></i>&nbsp' . __('Create Support Request'),
                'url' => route('user.support.create'),
            ]
        ];
        $support = Support::where('user_id', Auth::id())->with('conversations')->findOrFail($id);


        return Inertia::render('User/Support/Show', [
            'support' => $support,
            'buttons' => $buttons,
            'segments' => $segments,
        ]);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|max:1000',
        ]);

        $support = Support::where('user_id', Auth::id())->where('status', 1)->findOrFail($id);

        $support->conversations()->create([
            'comment'  => $request->message,
            'is_admin' => 0,
            'seen' => 0,
            'user_id'  => Auth::id()
        ]);

        return back();
    }
}
