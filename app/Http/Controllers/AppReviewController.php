<?php

namespace App\Http\Controllers;

use App\Models\AppReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class AppReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'rating' => 'required|numeric|min:1|max:5',
            'review' => 'required|string|max:500',
        ]);

        $badWords = [];
        $badWordsPath = storage_path('app/badwords.json');
        
        if (file_exists($badWordsPath)) {
            $badWords = json_decode(file_get_contents($badWordsPath), true) ?? [];
        } elseif (Storage::exists('badwords.json')) {
            $badWords = json_decode(Storage::get('badwords.json'), true) ?? [];
        }
        
        $leet = [
            'a' => '[aA4@]', 'b' => '[bB8]', 'e' => '[eE3]', 'i' => '[iI1\!\|]', 
            'o' => '[oO0]', 's' => '[sS5\$]', 't' => '[tT7]', 'g' => '[gG9]'
        ];

        foreach ($badWords as $word) {
            $regex = '';
            foreach (str_split($word) as $char) {
                $regex .= (isset($leet[$char]) ? $leet[$char] : preg_quote($char, '/')) . '[\W_]*';
            }
            $regex = substr($regex, 0, -6);
            
            $pattern = '/' . $regex . '/i';

            if (preg_match($pattern, $request->review)) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json(['success' => false, 'message' => 'Ulasan Anda mengandung kata-kata yang tidak pantas.']);
                }
                return back()->with('error', 'Ulasan Anda mengandung kata-kata yang tidak pantas.')->withInput();
            }
        }

        // Cek apakah user sudah pernah review
        $existing = AppReview::where('user_id', Auth::id())->first();
        $isUpdate = false;

        if ($existing) {
            $existing->update([
                'rating' => $request->rating,
                'review' => $request->review,
            ]);
            $review = $existing;
            $message = 'Ulasan berhasil diperbarui! Terima kasih';
            $isUpdate = true;
        } else {
            $review = AppReview::create([
                'user_id' => Auth::id(),
                'rating'  => $request->rating,
                'review'  => $request->review,
            ]);
            $message = 'Ulasan berhasil dikirim! Terima kasih';
        }

        if ($request->ajax() || $request->wantsJson()) {
            $user = Auth::user();
            return response()->json([
                'success' => true,
                'message' => $message,
                'is_update' => $isUpdate,
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
