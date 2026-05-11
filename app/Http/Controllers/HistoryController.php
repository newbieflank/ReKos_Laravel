<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tenant;
use App\Models\BoardingHouseReview;
use App\Models\BoardingHouse;
use App\Services\ContentFilterService;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    protected ContentFilterService $contentFilter;

    public function __construct(ContentFilterService $contentFilter)
    {
        $this->contentFilter = $contentFilter;
    }

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

        if ($request->filled('review')) {
            $filterResult = $this->contentFilter->check($request->review);
            if (!$filterResult['is_clean']) {
                $categories = collect($filterResult['violations'])->pluck('label')->implode(', ');
                $message = "Ulasan tidak dapat dikirim karena mengandung konten yang tidak diperbolehkan ({$categories}). Mohon gunakan bahasa yang sopan dan sesuai.";
                return back()->with('error', $message)->withInput();
            }
        }

        $existing = BoardingHouseReview::where('tenant_id', Auth::id())
            ->where('boarding_house_id', $request->boarding_house_id)
            ->first();

        if ($existing) {
            $existing->update([
                'rating' => $request->rating,
                'review' => $request->review,
            ]);
            $message = 'Ulasan berhasil diperbarui! Terima kasih atas ulasan Anda.';
        } else {
            BoardingHouseReview::create([
                'tenant_id' => Auth::id(),
                'boarding_house_id' => $request->boarding_house_id,
                'rating' => $request->rating,
                'review' => $request->review,
            ]);
            $message = 'Terima kasih atas ulasan Anda!';
        }
      
        $avgRating = BoardingHouseReview::where('boarding_house_id', $request->boarding_house_id)->avg('rating');
        BoardingHouse::where('id', $request->boarding_house_id)->update(['rating' => $avgRating]);

        return back()->with('success', $message);
    }
}
