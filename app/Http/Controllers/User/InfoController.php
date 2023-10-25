<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Traits\Uploader;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\ValidationException;

class InfoController extends Controller
{
    use Uploader;

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $user = User::findOrFail(auth()->id());
        $socials = json_decode($user->meta ?? null);
        $countries = File::get(database_path('json/country.json'));
        return Inertia::render('Frontend/Dashboard/Info/Edit', [
            'user' => $user,
            'socials' => $socials,
            'countries' => json_decode($countries),
        ]);
    }

      /**
     * update resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = User::findOrFail(auth()->id());
        if ($request->hasFile('avatar')) {
            $request->validate([
                'avatar'  => 'image|max:2000',
            ]);
            $avatar = $this->saveFile($request, 'avatar');

            $user->avatar =  $avatar;
            $user->save();
            return back();
        }
        if ($request->hasFile('cover_image')) {
            $request->validate([
                'cover_image'  => 'image|max:5000|dimensions:max_width=1920,max_height=250',
            ], [
                'dimensions' => ':attribute must be max 1920x250'
            ]);
            $cover_image = $this->saveFile($request, 'cover_image');

            $user->cover_image =  $cover_image;
            $user->save();
            return back();
        }
        if (!is_null($user->provider) && !is_null($user->provider_id) && $user->email == $request->email) {
            throw ValidationException::withMessages(['email' => 'You can not change email']);
        }
        $validatedData = $request->validate([
            'email'     => 'required|email|unique:users,email,' . auth()->id(),
            'phone'     => 'required|numeric|unique:users,phone,' . auth()->id(),
            'name'      => ['required', 'string', 'max:100'],
            'country'      => ['nullable', 'string', 'max:100'],
        ]);

        $user->name = $validatedData['name'];
        $user->email =  $validatedData['email'];
        $user->phone =  $validatedData['phone'];
        $user->country =  $validatedData['country'];
        $user->meta =  json_encode($request->meta);

        $user->save();

        return back();
    }
}
