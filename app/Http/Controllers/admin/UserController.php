<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\RoleRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function pencariKos()
    {
        $users = User::with(['userDetail', 'rentals.room.boardingHouse'])
            ->where('role', 'tenant')
            ->get();
        $title = "Pencari Kos";

        return view('admin.tabel-layout', compact('users', 'title'));
    }

    public function pemilikKos()
    {
        $users = User::With(['userDetail', 'boardingHouses'])->where('role', 'owner')->get();
        // dd($users);
        $title = "Pemilik Kost";

        return view('admin.tabel-layout', compact('users', 'title'));
    }

    public function persetujuan()
    {
        $requests = RoleRequest::with(['user.userDetail'])
            ->where('status', 'pending')
            ->get();

        $title = "Persetujuan Kost";

        return view('admin.tabel-layout', [
            'users' => $requests,
            'title' => $title
        ]);
    }
}
