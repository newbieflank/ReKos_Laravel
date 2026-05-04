<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserDetail;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::where('email', $googleUser->email)->first();

            if ($user) {
                $user->update(['google_id' => $googleUser->id]);
                Auth::login($user);
            } else {
                $newUser = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'password' => bcrypt(Str::random(16)),
                ]);

                UserDetail::create([
                    'user_id' => $newUser->id,
                    'phone'   => null,
                ]);

                Auth::login($newUser);
            }

            return redirect()->route('home');
        } catch (Exception $e) {
            return redirect('login')->with('error', 'Terjadi kesalahan saat pendaftaran.');
        }
    }
}
