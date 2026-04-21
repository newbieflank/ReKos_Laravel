<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function pencariKos()
    {
        $users = [
            ['id' => '00001', 'name' => 'Christine Brooks', 'phone' => '089 Kutch Green Apt. 448', 'date' => '04 Sep 2019', 'instansi' => 'Electric'],
            ['id' => '00002', 'name' => 'Rosie Pearson', 'phone' => '979 Immanuel Ferry Suite 526', 'date' => '28 May 2019', 'instansi' => 'Book'],
            ['id' => '00003', 'name' => 'Darrell Caldwell', 'phone' => '8587 Frida Ports', 'date' => '23 Nov 2019', 'instansi' => 'Medicine'],
        ];

        $title = "Pencari Kos";

        return view('admin.tabel-layout', compact('users', 'title'));
    }

    public function pemilikKos()
    {
        $users = [
            ['id' => '00004', 'name' => 'Gilbert Johnston', 'phone' => '7664 Amber Valley', 'date' => '12 Jan 2020', 'instansi' => 'Property'],
            ['id' => '00005', 'name' => 'Alan McDonald', 'phone' => '8821 King Street', 'date' => '05 Feb 2020', 'instansi' => 'Real Estate'],
        ];

        $title = "Pemilik Kost";

        return view('admin.tabel-layout', compact('users', 'title'));
    }

    public function persetujuan()
    {
        $users = [
            ['id' => '00006', 'name' => 'Kos Mawar Indah', 'phone' => 'Jl. Melati No. 12', 'date' => '10 Oct 2023', 'instansi' => 'Bapak Budi'],
        ];

        $title = "Persetujuan Kost";

        return view('admin.tabel-layout', compact('users', 'title'));
    }
}