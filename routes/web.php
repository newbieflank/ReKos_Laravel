<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\KosController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\PemilikKosController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'auth_login'])->name('login.auth');
Route::post('/register', [AuthController::class, 'auth_register'])->name('register.auth');

Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/detailkos', [KosController::class, 'showDetail'])->name('detail');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/image', [ProfileController::class, 'updateImage'])->name('profile.image.update');

    Route::middleware(['role:owner'])->group(function () {
        //middleware dan route khusus untuk pemilik kos
    });
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    
    Route::get('/pencari-kos', [UserController::class, 'pencariKos'])->name('pencari-kos');
    Route::get('/pemilik-kos', [UserController::class, 'pemilikKos'])->name('pemilik-kos');
    Route::get('/persetujuan', [UserController::class, 'persetujuan'])->name('persetujuan');
});

Route::prefix('pemilik')->name('pemilik.')->group(function () {
    Route::get('/dashboard', [PemilikKosController::class, 'dashboard'])->name('dashboard');
    Route::get('/kost', function() { return 'Halaman Data Kost'; })->name('kost');
    Route::get('/kamar', [PemilikKosController::class, 'kamar'])->name('kamar');
    
    Route::get('/penyewa', [PemilikKosController::class, 'penyewa'])->name('penyewa');
    Route::get('/penyewa/tambah', [PemilikKosController::class, 'tambahPenyewa'])->name('penyewa.tambah');
    
    Route::post('/penyewa/simpan', [PemilikKosController::class, 'simpanPenyewa'])->name('penyewa.simpan');
});