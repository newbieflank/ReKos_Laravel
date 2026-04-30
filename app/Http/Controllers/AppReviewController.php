<?php

namespace App\Http\Controllers;

use App\Models\AppReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AppReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'rating' => 'required|numeric|min:1|max:5',
            'review' => 'required|string|max:500',
        ]);

        // Cek apakah user sudah pernah review
        $existing = AppReview::where('user_id', Auth::id())->first();

        if ($existing) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Kamu sudah pernah memberikan ulasan sebelumnya.']);
            }
            return back()->with('error', 'Kamu sudah pernah memberikan ulasan sebelumnya.');
        }

        $review = AppReview::create([
            'user_id' => Auth::id(),
            'rating'  => $request->rating,
            'review'  => $request->review,
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            $user = Auth::user();
            return response()->json([
                'success' => true,
                'message' => 'Ulasan berhasil dikirim! Terima kasih 🎉',
                'data' => [
                    'rating' => $review->rating,
                    'review' => $review->review,
                    'user_name' => $user->name,
                    'user_city' => $user->userDetail?->city ?? 'Pengguna Re-Kost',
                    'user_avatar' => Storage::disk('public')->exists('avatars/' . $user->id . '.jpg') ? asset('storage/avatars/' . $user->id . '.jpg') : null,
                    'user_initial' => strtoupper(substr($user->name, 0, 1))
                ]
            ]);
        }

        return back()->with('success', 'Ulasan berhasil dikirim! Terima kasih 🎉');
    }
}
