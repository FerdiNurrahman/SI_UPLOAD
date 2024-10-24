<?php

use App\Http\Controllers\PhotoController;

Route::get('/', [PhotoController::class, 'index']);
Route::post('/upload', [PhotoController::class, 'store']);
