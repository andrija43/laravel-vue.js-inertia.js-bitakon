<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Storage;
use Hash;
use Inertia\Inertia;
use Str;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function settings()
    {
        $segments = request()->segments();
        $buttons = [
            [
                'name' => __('Back to dashboard'),
                'url' => url('admin/dashboard'),
            ]
        ];
        $user = User::findOrFail(Auth::id());
        return Inertia::render('Admin/Profile/Edit', [
            'segments' => $segments,
            'buttons' => $buttons,
            'user' => $user,
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $type
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $type)
    {
        $user = User::findOrFail(Auth::id());

        if ($type == 'password') {
            $validatedData = $request->validate([
                'password'      => ['required', 'string', 'min:8', 'max:100', 'confirmed'],
                'oldpassword' => ['required', 'string'],
            ]);

            $check = Hash::check($request->oldpassword, auth()->user()->password);
            if ($check == true) {
                $user->password = Hash::make($request->password);
            } else {
                return response()->json([
                    'message' => __('Old password is wrong'),
                ], 403);
            }

            $message = __('Password Updated Successfully');
        } elseif ($type == 'auth-key') {
            $user->authkey = $this->generateAuthKey();
            $user->save();

            return response()->json([
                'redirect' => url('user/auth-key'),
                'message' => __('Auth Key ReGenerated successfully.')
            ]);
        } else {
            $validatedData = $request->validate([
                'user.email'     => 'required|email|unique:users,email,' . Auth::id(),
                'user.phone'     => 'required|numeric|unique:users,phone,' . Auth::id(),
                'user.name'      => ['required', 'string', 'max:100'],
                'user.address'   => ['required', 'string', 'max:150'],
                'user.avatar'    => ['nullable', 'image', 'max:1024'],
            ]);

            $user->name = $validatedData['user']['name'];
            $user->email =  $validatedData['user']['email'];
            $user->phone =  $validatedData['user']['phone'];
            $user->country =  $validatedData['user']['address'];


            if ($request->hasFile('user.avatar')) {
                $file = $request->file('user.avatar');
                $ext = $file->extension();
                $filename = now()->timestamp . '.' . $ext;

                $path = 'uploads/' . \Auth::id() . date('/y') . '/' . date('m') . '/';
                $filePath = $path . $filename;
                Storage::put($filePath, file_get_contents($file));
                if ($user->avatar != null) {
                    $fileArr = explode('uploads', $user->avatar);
                    if (isset($fileArr[1])) {
                        $oldavatar = 'uploads' . $fileArr[1];
                        if (Storage::exists($oldavatar)) {
                            Storage::delete($oldavatar);
                        }
                    }
                }
                $user->avatar = Storage::url($filePath);
            }
        }

        $user->save();

        return redirect()->back();
    }
}
