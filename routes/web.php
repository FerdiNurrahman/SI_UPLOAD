<?php

use App\Http\Controllers\PhotoController;
use App\Http\Controllers\login;
use App\Http\Controllers\coba;
use App\Http\model\Accounts;

Route::get('/', [coba::class, 'index']);


Route::get('/login', [Login::class, 'index'])->name('login');
Route::post('/login', [Login::class, 'authenticate']);
Route::post('/logout', [Login::class, 'logout'])->name('logout');


Route::middleware(['auth'])->group(function () {
    Route::get('/uploadFoto', [PhotoController::class, 'index']);
    Route::post('/upload', [PhotoController::class, 'store']);
    Route::delete('/delete/{id}', [PhotoController::class, 'destroy']);
    Route::post('/logout', [Login::class, 'logout'])->name('logout'); // Tambah route untuk logout
});


