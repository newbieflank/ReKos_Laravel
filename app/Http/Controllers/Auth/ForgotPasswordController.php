<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Mail\SendOtpMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{
    /**
     * Tampilkan form untuk memasukkan email lupa password.
     */
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Buat OTP, simpan ke database, dan kirim ke email pengguna.
     */
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.exists' => 'Alamat email tidak terdaftar di sistem kami.',
        ]);

        $email = $request->email;
        
        // Generate 6 digit OTP
        $otp = (string) rand(100000, 999999);
        
        // Simpan ke database password_otps (hapus dulu yang lama untuk email ini)
        DB::table('password_otps')->where('email', $email)->delete();
        
        DB::table('password_otps')->insert([
            'email' => $email,
            'otp' => $otp,
            'expires_at' => Carbon::now()->addMinutes(10),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        try {
            // Kirim email
            Mail::to($email)->send(new SendOtpMail($otp));
            
            // Simpan email di session untuk tahap selanjutnya
            session(['reset_email' => $email]);
            
            return redirect()->route('password.otp')
                ->with('success', 'Kode OTP telah dikirim ke email Anda. Silakan periksa kotak masuk atau folder spam.');
        } catch (\Exception $e) {
            // Hapus OTP yang baru dibuat jika gagal kirim email
            DB::table('password_otps')->where('email', $email)->delete();
            
            return back()->withErrors(['email' => 'Gagal mengirim email OTP. Silakan coba beberapa saat lagi.']);
        }
    }

    /**
     * Tampilkan form input OTP.
     */
    public function showVerifyOtpForm()
    {
        if (!session()->has('reset_email')) {
            return redirect()->route('password.request')
                ->withErrors(['email' => 'Silakan masukkan email Anda terlebih dahulu.']);
        }

        return view('auth.verify-otp');
    }

    /**
     * Validasi kode OTP yang dimasukkan pengguna.
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|array',
            'otp.*' => 'required|numeric|digits:1',
        ], [
            'otp.required' => 'Kode OTP wajib diisi lengkap.',
        ]);

        if (!session()->has('reset_email')) {
            return redirect()->route('password.request')
                ->withErrors(['email' => 'Sesi Anda telah kedaluwarsa. Silakan masukkan email kembali.']);
        }

        $email = session('reset_email');
        
        // Gabungkan array input OTP menjadi satu string 6 digit
        $inputOtp = implode('', $request->otp);

        // Cari OTP di database yang masih berlaku (expires_at > now)
        $otpRecord = DB::table('password_otps')
            ->where('email', $email)
            ->where('otp', $inputOtp)
            ->where('expires_at', '>', Carbon::now())
            ->first();

        if (!$otpRecord) {
            return back()->withErrors(['otp' => 'Kode OTP salah atau telah kedaluwarsa. Silakan coba lagi.']);
        }

        // Tandai di session bahwa OTP sudah sukses diverifikasi
        session(['otp_verified' => true]);
        
        // Hapus kode OTP agar tidak bisa dipakai ulang
        DB::table('password_otps')->where('email', $email)->delete();

        return redirect()->route('password.reset');
    }

    /**
     * Tampilkan form reset password.
     */
    public function showResetPasswordForm()
    {
        if (!session()->has('reset_email') || !session()->has('otp_verified')) {
            return redirect()->route('password.request')
                ->withErrors(['email' => 'Silakan verifikasi OTP Anda terlebih dahulu.']);
        }

        return view('auth.reset-password');
    }

    /**
     * Perbarui password di database.
     */
    public function resetPassword(Request $request)
    {
        if (!session()->has('reset_email') || !session()->has('otp_verified')) {
            return redirect()->route('password.request')
                ->withErrors(['email' => 'Akses ditolak. Silakan ulangi proses lupa password.']);
        }

        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ], [
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal terdiri dari 8 karakter.',
        ]);

        $email = session('reset_email');

        // Cari user berdasarkan email dan update password
        $user = User::where('email', $email)->first();
        if ($user) {
            $user->update([
                'password' => Hash::make($request->password)
            ]);
            
            // Bersihkan session
            session()->forget(['reset_email', 'otp_verified']);
            
            return redirect()->route('login')
                ->with('success', 'Password Anda berhasil diperbarui! Silakan masuk menggunakan password baru.');
        }

        return redirect()->route('password.request')
            ->withErrors(['email' => 'Pengguna tidak ditemukan. Silakan coba kembali.']);
    }
}
