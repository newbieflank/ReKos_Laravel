<?php

namespace App\Http\Controllers;

use App\Models\RoleRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleRequestController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'ktp_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        $user = Auth::user();

        if ($user->role !== 'tenant') {
            return back()->with('error', 'Hanya penyewa yang bisa mengajukan diri menjadi owner.');
        }

        $existingRequest = RoleRequest::where('user_id', $user->id)
            ->where('status', 'pending')
            ->first();

        if ($existingRequest) {
            return back()->with('error', 'Anda sudah memiliki pengajuan yang sedang diproses.');
        }

        $ktpPath = $request->file('ktp_image')->store('ktp_images', 'public');

        // Buat pengajuan baru
        RoleRequest::create([
            'user_id' => $user->id,
            'ktp_image' => $ktpPath,
            'status' => 'pending'
        ]);

        // Kirim email notifikasi ke semua admin (di-queue di background)
        $admins = \App\Models\User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            \Illuminate\Support\Facades\Mail::to($admin->email)->send(new \App\Mail\RoleRequestNotificationAdmin($user));
        }

        return back()->with('success', 'Pengajuan berhasil dikirim! Silakan tunggu konfirmasi admin.');
    }
}
