<?php

use App\Http\Controllers\PhotoController;

Route::get('/', [PhotoController::class, 'index']);
Route::post('/upload', [PhotoController::class, 'store']);
Route::delete('/delete/{id}', [PhotoController::class, 'destroy']);  // Rute untuk menghapus foto
