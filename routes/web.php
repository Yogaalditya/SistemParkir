<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ParkingFlowController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (! auth()->check()) {
        return redirect()->route('login');
    }

    if (auth()->user()->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }

    return redirect()->route('user.dashboard');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.process');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'user'])->name('user.dashboard');
    Route::get('/scan', [ParkingFlowController::class, 'scanByUser'])->name('parking.scan-user');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'admin'])->name('admin.dashboard');
    Route::get('/admin/qr-code', [DashboardController::class, 'qrCode'])->name('admin.qr-code');
    Route::post('/admin/sessions/{session}/confirm-cash', [DashboardController::class, 'confirmCash'])->name('admin.confirm-cash');
});

Route::get('/scan/{token}', [ParkingFlowController::class, 'scan'])->name('parking.scan');
Route::post('/scan/{token}/pay', [ParkingFlowController::class, 'pay'])->name('parking.pay');
Route::get('/parkir/{session}/status', [ParkingFlowController::class, 'status'])->name('parking.status');
Route::post('/parkir/{session}/checkout', [ParkingFlowController::class, 'checkout'])->name('parking.checkout');
