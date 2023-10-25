<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class PasswordController extends Controller
{
    
     /**
     * Display the specified resource.
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        if (!is_null(auth()->user()->provider) && !is_null(auth()->user()->provider_id)) {
            return back();
        }
        return Inertia::render('Frontend/Dashboard/Password/Edit');
    }

     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if (!is_null(auth()->user()->provider) && !is_null(auth()->user()->provider_id)) {
            throw ValidationException::withMessages(['password' => 'You can not change password']);
        }
        $user = User::findOrFail(auth()->id());
        $request->validate([
            'password'      => ['required', 'string', 'min:8', 'max:100', 'confirmed'],
            'oldpassword' => ['required', 'string'],
        ]);

        $check = Hash::check($request->oldpassword, auth()->user()->password);
        if ($check == true) {
            $user->password = Hash::make($request->password);
        } else {
            throw ValidationException::withMessages(['password' => 'Old password not match']);
        }
        $user->save();

        return back();
    }
}
