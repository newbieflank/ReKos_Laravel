<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // Menampilkan Halaman Profile
    public function edit()
    {
        $user = Auth::user()->load('userDetail');
        return view('auth.profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|numeric',
            'gender' => 'required|in:male,female,unknown',
            'birth_date' => 'required|date',
            'occupation' => 'nullable|string|max:100',
            'institution' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
            'address' => 'nullable|string',
        ]);

        $user->update(['name' => $request->name]);

        $user->userDetail()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'phone' => $request->phone,
                'gender' => $request->gender,
                'birth_date' => $request->birth_date,
                'occupation' => $request->occupation,
                'institution' => $request->institution,
                'city' => $request->city,
                'address' => $request->address,
            ]
        );

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function updateImage(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = Auth::user();
        $file = $request->file('avatar');

        $fileName = $user->id . '.jpg';

        $file->storeAs('avatars', $fileName, 'public');

        $user->update(['avatar' => 1]);
        return back()->with('success', 'Foto profil berhasil diganti!');
    }

    // --- Reset Password via OTP (Logged In) ---

    public function showResetPasswordRequest()
    {
        return view('profile.reset-password.request');
    }

    public function sendResetOtp()
    {
        $user = Auth::user();
        $email = $user->email;
        
        $otp = (string) rand(100000, 999999);
        
        \Illuminate\Support\Facades\DB::table('password_otps')->where('email', $email)->delete();
        \Illuminate\Support\Facades\DB::table('password_otps')->insert([
            'email' => $email,
            'otp' => $otp,
            'expires_at' => \Carbon\Carbon::now()->addMinutes(10),
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        try {
            dispatch(function () use ($email, $otp) {
                \Illuminate\Support\Facades\Mail::to($email)->send(new \App\Mail\SendOtpMail($otp));
            })->afterResponse();
            
            session(['profile_reset_email' => $email]);
            return redirect()->route('profile.reset-password.verify')
                ->with('success', 'Kode OTP telah dikirim ke email Anda.');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::table('password_otps')->where('email', $email)->delete();
            return back()->withErrors(['email' => 'Gagal mengirim email OTP. Silakan coba lagi.']);
        }
    }

    public function showVerifyOtp()
    {
        if (!session()->has('profile_reset_email')) {
            return redirect()->route('profile.edit')->withErrors(['email' => 'Sesi tidak valid.']);
        }
        return view('profile.reset-password.verify');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|array',
            'otp.*' => 'required|numeric|digits:1',
        ]);

        if (!session()->has('profile_reset_email')) {
            return redirect()->route('profile.edit')->withErrors(['email' => 'Sesi telah kedaluwarsa.']);
        }

        $email = session('profile_reset_email');
        $inputOtp = implode('', $request->otp);

        $otpRecord = \Illuminate\Support\Facades\DB::table('password_otps')
            ->where('email', $email)
            ->where('otp', $inputOtp)
            ->where('expires_at', '>', \Carbon\Carbon::now())
            ->first();

        if (!$otpRecord) {
            return back()->withErrors(['otp' => 'Kode OTP salah atau kedaluwarsa.']);
        }

        session(['profile_otp_verified' => true]);
        \Illuminate\Support\Facades\DB::table('password_otps')->where('email', $email)->delete();

        return redirect()->route('profile.reset-password.new');
    }

    public function showNewPasswordForm()
    {
        if (!session()->has('profile_reset_email') || !session()->has('profile_otp_verified')) {
            return redirect()->route('profile.edit')->withErrors(['email' => 'Verifikasi OTP diperlukan.']);
        }
        return view('profile.reset-password.new-password');
    }

    public function updatePassword(Request $request)
    {
        if (!session()->has('profile_reset_email') || !session()->has('profile_otp_verified')) {
            return redirect()->route('profile.edit');
        }

        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();
        $user->update([
            'password' => \Illuminate\Support\Facades\Hash::make($request->password)
        ]);
        
        session()->forget(['profile_reset_email', 'profile_otp_verified']);
        
        return redirect()->route('profile.edit')->with('success', 'Kata sandi berhasil diperbarui!');
    }
}
