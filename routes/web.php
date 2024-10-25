<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;

// Route untuk login dan autentikasi
Route::get('/', [LoginController::class, 'index'])->name('login'); // Halaman login
Route::post('/login', [LoginController::class, 'authenticate']); // Proses autentikasi
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Route yang memerlukan autentikasi
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/uploadFoto', [AdminController::class, 'TampilFoto']);
    Route::post('/upload', [AdminController::class, 'store']);
    Route::delete('/delete/{id}', [AdminController::class, 'destroy']);
});
