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
use App\Http\Controllers\AppReviewController;
use App\Http\Controllers\RoleRequestController;
use App\Http\Controllers\HistoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $rooms = \App\Models\Room::with('boardingHouse')->where('available', true)->take(12)->get();
    $reviews = \App\Models\AppReview::with('user')->latest()->take(12)->get();

    $allAlamat = \App\Models\BoardingHouse::pluck('alamat');
    $areas = [];
    foreach($allAlamat as $al) {
        if(!$al) continue;
        $parts = array_map('trim', explode(',', $al));
        if (count($parts) >= 6 && strtolower($parts[count($parts) - 5]) === 'bondowoso') {
            $kelurahan = $parts[count($parts) - 6];
            $areas[$kelurahan] = true;
        } elseif (count($parts) > 1) {
            $areas[$parts[1]] = true;
        }
    }
    $areas = array_keys($areas);
    sort($areas);

    return view('welcome', compact('rooms', 'reviews', 'areas'));
})->name('home');

Route::get('/kos-terbaik', [kosTerbaikController::class, 'index'])->name('kosterbaik.index');
Route::get('/all-kos', [allKosController::class, 'index'])->name('allkos.index');

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'auth_login'])->name('login.auth');
Route::post('/register', [AuthController::class, 'auth_register'])->name('register.auth');


Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/ajukan-owner', [RoleRequestController::class, 'store'])->name('role.request');
    Route::post('/app-review', [AppReviewController::class, 'store'])->name('app.review.store');

    Route::get('/riwayat', [HistoryController::class, 'index'])->name('user.history');
    Route::post('/riwayat/review', [HistoryController::class, 'storeReview'])->name('user.history.review');

    Route::get('/payment/create/{id}', [PaymentController::class, 'create'])->name('payments.create');
    Route::post('/payment/save1', [PaymentController::class, 'save1'])->name('payments.save1');
    Route::get('/payment/pembayaran', [PaymentController::class, 'payment'])->name('payments.pembayaran');
    Route::post('/payment/save2', [PaymentController::class, 'save2'])->name('payments.save2');
    Route::get('/payment/konfirmasi', [PaymentController::class, 'confirmation'])->name('payments.konfirmasi');
    Route::get('/payments/success', [PaymentController::class, 'success'])
        ->name('payments.success');
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
            Route::post('/kost/{id}/kamar/{room_id}/duplicate', [PemilikKosController::class, 'duplicateKamar'])->name('kamar.duplicate');

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
