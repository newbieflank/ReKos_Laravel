<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Request;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function auth_login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->has('remember'))) {

            $request->session()->regenerate();

            $user = Auth::user();

            if ($user->role === 'owner') {
                return redirect()->route('pemilik.dashboard')
                    ->with('success', 'Selamat datang Owner, ' . $user->name . '!');
            }

            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard')
                    ->with('success', 'Selamat datang Admin, ' . $user->name . '!');
            }

            return redirect()->route('home')
                ->with('success', 'Selamat datang kembali, ' . $user->name . '!');
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    public function auth_register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'phone'    => 'required|numeric',
            'password' => 'required|string|min:8',
        ]);

        DB::beginTransaction();

        try {
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),

            ]);

            UserDetail::create([
                'user_id' => $user->id,
                'phone'   => $request->phone,
            ]);

            DB::commit();

            return redirect()->route('login')->with('success', 'Registrasi berhasil!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Gagal Register: " . $e->getMessage());

            return back()->withErrors(['error' => 'Terjadi kesalahan saat pendaftaran.']);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Anda telah berhasil keluar.');
    }
}
