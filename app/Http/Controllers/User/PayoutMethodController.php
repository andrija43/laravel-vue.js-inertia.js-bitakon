<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\PayoutMethod;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PayoutMethodController extends Controller
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
        $methods = PayoutMethod::latest()->where('status', 1)->get();

        return Inertia::render('User/PayoutMethod/Index', [
            'methods' => $methods,
            'buttons' => $buttons,
            'segments' => $segments,
        ]);
    }

     /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $segments = request()->segments();
        $buttons = [
            [
                'name' => __('Back'),
                'url' => route('user.payout-methods.index'),
            ]
        ];
        $payoutmethod = PayoutMethod::find($id);

        return Inertia::render('User/PayoutMethod/Edit', [
            'segments' => $segments,
            'buttons' => $buttons,
            'payoutmethod' => $payoutmethod,
        ]);
    }
}
