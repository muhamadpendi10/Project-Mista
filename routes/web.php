<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UploadController;

Route::get('/upload', [UploadController::class, 'index']);
Route::post('/upload', [UploadController::class, 'store']);

