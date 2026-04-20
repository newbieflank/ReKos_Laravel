<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // Menampilkan Halaman Profile
    public function edit()
    {
        $user = Auth::user()->load('userDetail');
        return view('auth.profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|numeric',
            'gender' => 'required|in:male,female,unknown',
            'birth_date' => 'nullable|date',
            'occupation' => 'nullable|string|max:100',
            'institution' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
            'address' => 'nullable|string',
        ]);

        $user->update(['name' => $request->name]);

        $user->userDetail()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'phone' => $request->phone,
                'gender' => $request->gender,
                'birth_date' => $request->birth_date,
                'occupation' => $request->occupation,
                'institution' => $request->institution,
                'city' => $request->city,
                'address' => $request->address,
            ]
        );

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function updateImage(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = Auth::user();
        $file = $request->file('avatar');

        $fileName = $user->id . '.jpg';

        $file->storeAs('avatars', $fileName, 'public');

        $user->update(['avatar' => 1]);
        return back()->with('success', 'Foto profil berhasil diganti!');
    }
}
