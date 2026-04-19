<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KosController extends Controller
{
    public function showDetail()
    {
        // Data dummy super lengkap
        $kos = [
            'nama' => 'Kos Putri Muslimah Blindungan',
            'harga' => '500.000',
            'lokasi' => 'Blindungan, Bondowoso',
            'rating' => 4.5,
            'fasilitas_populer' => [
                ['nama' => 'Wifi', 'icon' => 'fa-solid fa-wifi'],
                ['nama' => 'Dapur', 'icon' => 'fa-solid fa-fire-burner'],
                ['nama' => '24 Jam', 'icon' => 'fa-regular fa-clock'],
                ['nama' => 'AC/Kipas Angin', 'icon' => 'fa-solid fa-fan'],
                ['nama' => 'Meja', 'icon' => 'fa-solid fa-table'],
                ['nama' => 'Parkir', 'icon' => 'fa-solid fa-square-parking'],
                ['nama' => 'Lemari', 'icon' => 'fa-solid fa-door-closed'],
                ['nama' => 'Mingguan/Bulanan', 'icon' => 'fa-regular fa-calendar'],
                ['nama' => 'Television', 'icon' => 'fa-solid fa-tv'],
            ],
            'fasilitas_lain' => ['Musholla', 'Supermarket', 'ATM/Bank', 'Laundry', 'Apotek'],
            'alamat_lengkap' => 'Jl. Mastrip, Krajan Timur, Sumbersari, Kec. Sumbersari, Kabupaten Jember, Jawa Timur 68121.',
            'kebijakan' => [
                ['judul' => 'Hewan Peliharaan', 'deskripsi' => 'Tidak diperbolehkan membawa hewan peliharaan.'],
                ['judul' => 'Tamu', 'deskripsi' => 'Tidak diperbolehkan membawa lawan jenis masuk kedalam kost/kamar.'],
                ['judul' => 'Deposit', 'deskripsi' => 'Teman menginap dikenakan biaya.'],
                ['judul' => 'Alkohol', 'deskripsi' => 'Tidak diperbolehkan membawa minuman keras atau obat-obatan.']
            ]
        ];

        return view('kos.detailkos', compact('kos'));
    }
}