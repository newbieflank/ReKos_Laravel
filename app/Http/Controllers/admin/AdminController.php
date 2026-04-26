<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\RoleRequest;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function approveRole($id)
    {
        $request = RoleRequest::findOrFail($id);

        $user = User::findOrFail($request->user_id);
        $user->update(['role' => 'owner']);

        $request->update(['status' => 'approved']);

        return back()->with('success', 'User ' . $user->name . ' sekarang resmi menjadi Owner.');
    }

    public function rejectRole($id)
    {
        $request = RoleRequest::findOrFail($id);

        $request->update(['status' => 'declined']);

        return back()->with('error', 'Pengajuan role telah ditolak.');
    }

    public function index()
    {
        $stats = [
            'pemilik_kos' => '40,689',
            'pencari_kos' => '10,293',
            'kos' => '$89,000',
            'rating' => '2040'
        ];

        $chartData = [
            25,
            28,
            48,
            38,
            51,
            31,
            39,
            52,
            86,
            34,
            52,
            47,
            42,
            54,
            38,
            45,
            61,
            24,
            31,
            27,
            47,
            43,
            72,
            58,
            62,
            53,
            52,
            58,
            42,
            56,
            51,
            57,
            51,
            58
        ];

        $chartCategories = [
            '5k',
            '',
            '10k',
            '',
            '15k',
            '',
            '20k',
            '',
            '25k',
            '',
            '30k',
            '',
            '35k',
            '',
            '40k',
            '',
            '45k',
            '',
            '50k',
            '',
            '55k',
            '',
            '60k',
            ''
        ];

        return view('admin.dashboard', compact('stats', 'chartData', 'chartCategories'));
    }
}
