<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\KosController;
use App\Http\Controllers\ProfileController;
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
