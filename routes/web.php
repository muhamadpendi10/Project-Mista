<?php

use App\Helpers\DeviceHelper;
use App\Http\Controllers\AdminDeviceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UploadController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/devices', [AdminDeviceController::class, 'index']);
    Route::post('/admin/devices/{id}/approve', [AdminDeviceController::class, 'approve']);
    Route::post('/admin/devices/{id}/reject', [AdminDeviceController::class, 'reject']);
    Route::post('/admin/devices/{id}/rename', [AdminDeviceController::class, 'rename']);
});

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/upload', [UploadController::class, 'index'])
        ->name('upload.index');

    Route::post('/upload', [UploadController::class, 'store'])
        ->name('upload.store');

    // history upload
    Route::get('/upload/history', [UploadController::class, 'history'])
        ->name('upload.history');

    // download ulang
    Route::get('/upload/{upload}/download', [UploadController::class, 'download'])
        ->name('upload.download');

});

