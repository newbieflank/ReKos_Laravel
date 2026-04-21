<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PemilikKosController extends Controller
{
    public function dashboard()
    {
        return view('pemilik.dashboard'); 
    }

    public function kamar()
    {
        return view('pemilik.kamar');
    }

    public function penyewa()
    {
        return view('pemilik.penyewa');
    }

    public function tambahPenyewa()
    {
        return view('pemilik.tambah-penyewa');
    }

    public function simpanPenyewa(Request $request)
    {
        return redirect()->route('pemilik.penyewa')->with('success', 'Data penyewa berhasil disimpan!');
    }
}