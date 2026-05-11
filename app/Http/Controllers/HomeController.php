<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $rooms = \App\Models\Room::with('boardingHouse')->where('available', true)->take(12)->get();
        $reviews = \App\Models\AppReview::with('user')->latest()->take(12)->get();

        $areas = [
            'Badean',
            'Blindungan',
            'Dabaan',
            'Kademangan',
            'Kauman',
            'Kotakulon',
            'Nangkaan',
            'Pancoran',
            'Pejaten',
            'Tamansari'
        ];

        $totalPengguna = \App\Models\User::count();
        $totalKost = \App\Models\BoardingHouse::count();

        $dataTerproses = $rooms->map(function ($kos) {
            if ($kos->monthly_price) {
                $kos->harga_hitung = $kos->monthly_price;
            } elseif ($kos->weekly_price) {
                $kos->harga_hitung = $kos->weekly_price * 4;
            } elseif ($kos->daily_price) {
                $kos->harga_hitung = $kos->daily_price * 30;
            } else {
                $kos->harga_hitung = null;
            }
            return $kos;
        })->filter(fn($kos) => $kos->harga_hitung !== null);

        $minHarga = $dataTerproses->min('harga_hitung');
        $maxRating = $dataTerproses->max('rating');

        $bobot = ['harga' => 0.6, 'rating' => 0.4];

        $rekomendasi = $dataTerproses->map(function ($kos) use ($minHarga, $maxRating, $bobot) {
            $normHarga = $minHarga / $kos->harga_hitung;
            $normRating = $maxRating > 0 ? $kos->rating / $maxRating : 0;
            $kos->skor = round(($normHarga * $bobot['harga']) + ($normRating * $bobot['rating']), 4);

            return $kos;
        })
            ->sortByDesc('skor')
            ->take(15)
            ->values();

        return view('welcome', compact('rooms', 'reviews', 'areas', 'totalPengguna', 'totalKost', 'rekomendasi'));
    }
}
