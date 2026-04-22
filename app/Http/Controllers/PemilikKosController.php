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

    public function tambahKamar()
    {
        return view('pemilik.tambah-kamar');
    }

    public function simpanKamar(Request $request)
    {
        return redirect()->route('pemilik.kamar')->with('success', 'Data kamar baru berhasil ditambahkan!');
    }

    public function kost()
    {
        return view('pemilik.kost');
    }

    public function tambahKost()
    {
        return view('pemilik.tambah-kost');
    }

    public function simpanKost(Request $request)
    {
        return redirect()->route('pemilik.kost')->with('success', 'Data Properti Kost berhasil ditambahkan!');
    }
}