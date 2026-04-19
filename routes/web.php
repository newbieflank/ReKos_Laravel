<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\KosController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'auth_login'])->name('login.auth');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.auth');

Route::get('/detailkos', [KosController::class, 'showDetail']);


