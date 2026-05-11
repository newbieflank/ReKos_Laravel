<?php

namespace App\Http\Controllers;

use App\Models\AppReview;
use App\Services\ContentFilterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AppReviewController extends Controller
{
    protected ContentFilterService $contentFilter;

    public function __construct(ContentFilterService $contentFilter)
    {
        $this->contentFilter = $contentFilter;
    }

    public function store(Request $request)
    {
        $request->validate([
            'rating' => 'required|numeric|min:1|max:5',
            'review' => 'required|string|max:500',
        ]);


        $filterResult = $this->contentFilter->check($request->review);

        if (!$filterResult['is_clean']) {
            $categories = collect($filterResult['violations'])->pluck('label')->implode(', ');
            $message = "Ulasan tidak dapat dikirim karena mengandung konten yang tidak diperbolehkan ({$categories}). Mohon gunakan bahasa yang sopan dan sesuai.";

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'filtered' => true,
                    'message' => $message,
                    'violations' => $filterResult['violations'],
                ]);
            }
            return back()->with('error', $message)->withInput();
        }


        $existing = AppReview::where('user_id', Auth::id())->first();

        if ($existing) {
            $existing->update([
                'rating' => $request->rating,
                'review' => $request->review,
            ]);
            $review = $existing;
            $message = 'Ulasan berhasil diperbarui! Terima kasih 🎉';
            $isUpdated = true;
        } else {
            $review = AppReview::create([
                'user_id' => Auth::id(),
                'rating'  => $request->rating,
                'review'  => $request->review,
            ]);
            $message = 'Ulasan berhasil dikirim! Terima kasih 🎉';
            $isUpdated = false;
        }

        if ($request->ajax() || $request->wantsJson()) {
            $user = Auth::user();
            return response()->json([
                'success' => true,
                'updated' => $isUpdated,
                'message' => $message,
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

        return back()->with('success', $message);
    }
}
