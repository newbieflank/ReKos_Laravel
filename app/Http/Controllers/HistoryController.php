<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tenant;
use App\Models\BoardingHouseReview;
use App\Models\BoardingHouse;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public function index()
    {
        $histories = Tenant::with(['room.boardingHouse', 'payments'])
            ->where('tenant_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        // dd($histories);

        $reviews = BoardingHouseReview::where('tenant_id', Auth::id())
            ->get()
            ->keyBy('boarding_house_id');

        return view('user.history', compact('histories', 'reviews'));
    }

    public function storeReview(Request $request)
    {
        $request->validate([
            'boarding_house_id' => 'required|exists:boarding_houses,id',
            'rating' => 'required|numeric|min:1|max:5',
            'review' => 'nullable|string|max:500',
        ]);

        $existing = BoardingHouseReview::where('tenant_id', Auth::id())
            ->where('boarding_house_id', $request->boarding_house_id)
            ->first();

        if ($existing) {
            return back()->with('error', 'Anda sudah memberikan rating untuk kost ini.');
        }

        BoardingHouseReview::create([
            'tenant_id' => Auth::id(),
            'boarding_house_id' => $request->boarding_house_id,
            'rating' => $request->rating,
            'review' => $request->review,
        ]);

        // Update average rating on boarding house
        $avgRating = BoardingHouseReview::where('boarding_house_id', $request->boarding_house_id)->avg('rating');
        BoardingHouse::where('id', $request->boarding_house_id)->update(['rating' => $avgRating]);

        return back()->with('success', 'Terima kasih atas ulasan Anda!');
    }
}
