<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartemenController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\KonfigurasiController;
use App\Http\Controllers\PresensiController;
use Illuminate\Support\Facades\Route;

// Guest Routes
Route::middleware(['guest:karyawan'])->group(function () {
    Route::get('/', function () {
        return view('auth.login');
    })->name('login');

    Route::post('/login', [AuthController::class, 'prosesLogin']);
});

Route::middleware(['guest:user'])->group(function () {
    Route::get('/panel/admin', function () {
        return view('auth.loginadmin');
    })->name('loginadmin');

    Route::post('/login/admin', [AuthController::class, 'prosesLoginAdmin']);
});

// Karyawan Routes
Route::middleware(['auth:karyawan'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/logout', [AuthController::class, 'prosesLogout']);

    Route::get('/profile/edit', [PresensiController::class, 'editProfile']);
    Route::post('/profile/update/{nik}', [PresensiController::class, 'updateProfile']);

    Route::prefix('/presensi')->group(function () {
        Route::get('/create', [PresensiController::class, 'create']);
        Route::post('/store', [PresensiController::class, 'store']);
        Route::get('/histori', [PresensiController::class, 'histori']);
        Route::post('/histori', [PresensiController::class, 'getHistori']);
        Route::get('/izin', [PresensiController::class, 'izin']);
        Route::get('/izin/create', [PresensiController::class, 'createIzin']);
        Route::post('/izin/store', [PresensiController::class, 'storeIzin']);
    });
});

// Admin Routes
Route::middleware('auth:user')->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'dashboardAdmin']);
    Route::get('/admin/logout', [AuthController::class, 'logoutAdmin']);

    Route::prefix('/karyawan')->group(function () {
        Route::get('/', [KaryawanController::class, 'index']);
        Route::post('/store', [KaryawanController::class, 'store']);
        Route::post('/edit', [KaryawanController::class, 'edit']);
        Route::post('/update/{nik}', [KaryawanController::class, 'update']);
        Route::post('/delete/{nik}', [KaryawanController::class, 'delete']);
    });

    Route::prefix('/departemen')->group(function () {
        Route::get('/', [DepartemenController::class, 'index']);
        Route::post('/store', [DepartemenController::class, 'store']);
        Route::post('/edit', [DepartemenController::class, 'edit']);
        Route::post('/update/{kode_dept}', [DepartemenController::class, 'update']);
        Route::post('/delete/{kode_dept}', [DepartemenController::class, 'delete']);
    });

    Route::prefix('/presensi')->group(function () {
        Route::get('/monitoring', [PresensiController::class, 'monitoring']);
        Route::post('/get', [PresensiController::class, 'getPresensi']);
        Route::post('/showmap', [PresensiController::class, 'showMap']);
        Route::get('/laporan', [PresensiController::class, 'laporan']);
        Route::post('/laporan/cetak', [PresensiController::class, 'cetakLaporan']);
        Route::get('/rekap', [PresensiController::class, 'rekap']);
        Route::post('/rekap/cetak', [PresensiController::class, 'cetakRekap']);
    });

    Route::prefix('/setting')->group(function () {
        Route::get('/lokasi', [KonfigurasiController::class, 'lokasiKantor']);
        Route::post('/lokasi/update', [KonfigurasiController::class, 'updateLokasi']);
    });
});