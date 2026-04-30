@extends('layouts.app')

@section('content')
    <div style="display:flex;justify-content:center;align-items:center;height:80vh;">
        <div
            style="background:#fff;padding:40px;border-radius:16px;text-align:center;box-shadow:0 2px 12px rgba(0,0,0,0.05);">

            <h2 style="color:#1E3A8A;margin-bottom:10px;">
                Pembayaran Berhasil
            </h2>

            <p style="color:#555;margin-bottom:20px;">
                Terima kasih! Transaksi Anda telah berhasil diproses.
            </p>

            <a href="/" class="btn-primary">
                Kembali ke Beranda
            </a>

        </div>
    </div>
@endsection
