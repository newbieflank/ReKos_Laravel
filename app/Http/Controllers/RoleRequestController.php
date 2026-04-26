<?php

namespace App\Http\Controllers;

use App\Models\RoleRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleRequestController extends Controller
{
    public function store()
    {
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

        // Buat pengajuan baru
        RoleRequest::create([
            'user_id' => $user->id,
            'status' => 'pending'
        ]);

        return back()->with('success', 'Pengajuan berhasil dikirim! Silakan tunggu konfirmasi admin.');
    }
}
