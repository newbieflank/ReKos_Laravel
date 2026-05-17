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

    public function index(Request $request)
    {
        $stats = [
            'pemilik_kos' => User::where('role', 'owner')->count(),
            'pencari_kos' => User::where('role', 'tenant')->count(),
            'kos' => BoardingHouse::count(),
            'rating' => AppReview::count(),
        ];

        $availableYears = User::selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();
            
        if (empty($availableYears)) {
            $availableYears = [date('Y')];
        }

        $currentYear = $request->query('year', date('Y'));

        $usersPerMonth = User::whereYear('created_at', $currentYear)
            ->select(
                DB::raw('COUNT(id) as total'),
                DB::raw('MONTH(created_at) as month_num')
            )
            ->groupBy('month_num')
            ->get()
            ->keyBy('month_num');

        $chartData = [];
        $chartCategories = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
        
        for ($i = 1; $i <= 12; $i++) {
            $chartData[] = isset($usersPerMonth[$i]) ? $usersPerMonth[$i]->total : 0;
        }

        return view('admin.dashboard', compact('stats', 'chartData', 'chartCategories', 'availableYears', 'currentYear'));
    }
}
