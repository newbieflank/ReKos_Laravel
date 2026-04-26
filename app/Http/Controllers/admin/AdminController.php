<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\AppReview;
use App\Models\BoardingHouse;
use App\Models\RoleRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            'pemilik_kos' => User::where('role', 'owner')->count(),
            'pencari_kos' => User::where('role', 'tenant')->count(),
            'kos' => BoardingHouse::count(),
            'rating' => AppReview::count(),
        ];

        $usersPerMonth = User::select(
            DB::raw('COUNT(id) as total'),
            DB::raw("DATE_FORMAT(created_at, '%b') as month"), // %b untuk nama bulan singkat (Jan, Feb)
            DB::raw("MIN(created_at) as sort_date")
        )
            ->groupBy('month')
            ->orderBy('sort_date', 'asc')
            ->get();

        $chartData = $usersPerMonth->pluck('total')->toArray();
        $chartCategories = $usersPerMonth->pluck('month')->toArray();

        return view('admin.dashboard', compact('stats', 'chartData', 'chartCategories'));
    }
}
