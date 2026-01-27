<?php

use App\Helpers\DeviceHelper;
use App\Http\Controllers\AdminDeviceController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UploadController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::middleware(['auth', 'admin'])->group(function () {
    // Route::get('/admin', function () {
    //     return 'HALAMAN ADMIN';
    // });
    Route::get('/admin/devices', [AdminDeviceController::class, 'index']);
    Route::post('/admin/devices/{id}/approve', [AdminDeviceController::class, 'approve']);
    Route::post('/admin/devices/{id}/revoked', [AdminDeviceController::class, 'reject']);
});

Route::middleware('auth')->group(function () {
    Route::get('/upload', [UploadController::class, 'index']);
    Route::post('/upload', [UploadController::class, 'store']);
});
