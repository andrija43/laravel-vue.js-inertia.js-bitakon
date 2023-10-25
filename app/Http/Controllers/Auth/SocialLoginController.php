<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class SocialLoginController extends Controller
{
    public function redirectTo($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleCallback(Request $request, $provider)
    {
       
       if (!$request->has('code') || $request->has('denied')) {
         
          return redirect(env('APP_URL').'/login')->withErrors([
                'auth' => $provider.' Login failed',
            ])->onlyInput('auth');
        }
       
        try {
            $user = Socialite::driver($provider)->user();

            $finduser = User::where('provider_id', $user->id)
                ->where('provider', $provider)
                ->where('email', $user->email)->first();
            $uuid = (string) Str::uuid();
            if ($finduser) {
                $finduser->update(['password' => Hash::make($uuid . $user->id)]);
                Auth::login($finduser);
                return redirect('/');
            } else {
                $uuid = (string) Str::uuid();
                $isNameUnique = User::where('name', $user->name)->count();
                $username = Str::of($user->name)
                    ->trim()
                    ->lower()
                    ->replace(' ', '')
                    ->append($isNameUnique > 0 ? $isNameUnique + 1 : '');

                $newUser = User::create([
                    'name' => $user->name,
                    'username' => $username,
                    'email' => $user->email,
                    'provider_id' => $user->id,
                    'provider' => $provider,
                    'password' => Hash::make($uuid . $user->id)
                ]);
                Auth::login($newUser);
                return redirect('/');
            }
        } catch (Exception $e) {
            return  $e->getMessage();
        }
    }
}
