<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BoardingHouse;

class KosController extends Controller
{
    public function showDetail($id)
    {
        $kos = BoardingHouse::with(['rooms', 'reviews'])->findOrFail($id);
        
        $hargaHarian = $kos->rooms()->min('daily_price') ?? 0;
        $hargaMingguan = $kos->rooms()->min('weekly_price') ?? 0;
        $hargaBulanan = $kos->rooms()->min('monthly_price') ?? 0;
        
        $sisaKamar = $kos->rooms->where('available', true)->count();
        $totalKamar = $kos->rooms->count();
        
        // Untuk rating dan jumlah review
        $reviewsCount = $kos->reviews()->count();
        $rating = $reviewsCount > 0 ? $kos->reviews()->avg('rating') : 0;

        return view('kos.detailkos', compact('kos', 'hargaHarian', 'hargaMingguan', 'hargaBulanan', 'rating', 'reviewsCount', 'sisaKamar', 'totalKamar'));
    }
}