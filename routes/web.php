<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\KosController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\landing\allKosController;
use App\Http\Controllers\landing\kosTerbaikController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PemilikKosController;
use App\Http\Controllers\RoleRequestController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $rooms = \App\Models\Room::with('boardingHouse')->where('available', true)->take(12)->get();
    return view('welcome', compact('rooms'));
})->name('home');

Route::get('/kos-terbaik', [kosTerbaikController::class, 'index'])->name('kosterbaik.index');
Route::get('/all-kos', [allKosController::class, 'index'])->name('allkos.index');

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'auth_login'])->name('login.auth');
Route::post('/register', [AuthController::class, 'auth_register'])->name('register.auth');


Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/detailkos', [KosController::class, 'showDetail'])->name('detail');
    Route::post('/ajukan-owner', [RoleRequestController::class, 'store'])->name('role.request');

    Route::get('/payment/create', [PaymentController::class, 'create'])->name('payments.create');
    Route::post('/payment/store', [PaymentController::class, 'store'])->name('payments.store');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/image', [ProfileController::class, 'updateImage'])->name('profile.image.update');

    Route::get('/kos/{id}', [KosController::class, 'showDetail'])->name('detail');

    Route::middleware(['role:owner'])->group(function () {
        Route::prefix('pemilik')->name('pemilik.')->group(function () {
            Route::get('/dashboard', [PemilikKosController::class, 'dashboard'])->name('dashboard');
            Route::get('/kost', [PemilikKosController::class, 'kost'])->name('kost');
            Route::get('/kost/tambah', [PemilikKosController::class, 'tambahKost'])->name('kost.tambah');
            Route::post('/kost/simpan', [PemilikKosController::class, 'simpanKost'])->name('kost.simpan');
            Route::get('/kost/{id}/edit', [PemilikKosController::class, 'editKost'])->name('kost.edit');
            Route::put('/kost/{id}/update', [PemilikKosController::class, 'updateKost'])->name('kost.update');
            Route::delete('/kost/{id}/hapus', [PemilikKosController::class, 'hapusKost'])->name('kost.hapus');

            Route::get('/kost/{id}/kamar', [PemilikKosController::class, 'kamar'])->name('kamar');
            Route::get('/kost/{id}/kamar/tambah', [PemilikKosController::class, 'tambahKamar'])->name('kamar.tambah');
            Route::post('/kost/{id}/kamar/simpan', [PemilikKosController::class, 'simpanKamar'])->name('kamar.simpan');
            Route::get('/kost/{id}/kamar/{room_id}/edit', [PemilikKosController::class, 'editKamar'])->name('kamar.edit');
            Route::put('/kost/{id}/kamar/{room_id}/update', [PemilikKosController::class, 'updateKamar'])->name('kamar.update');
            Route::delete('/kost/{id}/kamar/{room_id}/hapus', [PemilikKosController::class, 'hapusKamar'])->name('kamar.hapus');

            Route::get('/penyewa', [PemilikKosController::class, 'penyewa'])->name('penyewa');
            Route::get('/penyewa/tambah', [PemilikKosController::class, 'tambahPenyewa'])->name('penyewa.tambah');
            Route::post('/penyewa/simpan', [PemilikKosController::class, 'simpanPenyewa'])->name('penyewa.simpan');
            Route::get('/penyewa/{id}/edit', [PemilikKosController::class, 'editPenyewa'])->name('penyewa.edit');
            Route::put('/penyewa/{id}/update', [PemilikKosController::class, 'updatePenyewa'])->name('penyewa.update');
            Route::delete('/penyewa/{id}/hapus', [PemilikKosController::class, 'hapusPenyewa'])->name('penyewa.hapus');
        });
    });

    Route::middleware(['role:admin'])->group(function () {
        Route::prefix('admin')->name('admin.')->group(function () {
            Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

            Route::get('/pencari-kos', [UserController::class, 'pencariKos'])->name('pencari-kos');
            Route::get('/pemilik-kos', [UserController::class, 'pemilikKos'])->name('pemilik-kos');
            Route::get('/persetujuan', [UserController::class, 'persetujuan'])->name('persetujuan');

            Route::post('/approve-role/{id}', [AdminController::class, 'approveRole'])->name('approve-role');
            Route::post('/reject-role/{id}', [AdminController::class, 'rejectRole'])->name('reject-role');
        });
    });
});
