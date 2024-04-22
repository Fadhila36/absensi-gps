<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\PresensiController;
use Illuminate\Support\Facades\Route;


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

Route::middleware(['auth:karyawan'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/logout', [AuthController::class, 'prosesLogout']);

    // presensi
    Route::get('/presensi/create', [PresensiController::class, 'create']);
    Route::post('/presensi/store', [PresensiController::class, 'store']);

    Route::get('/editprofile', [PresensiController::class, 'editProfile']);
    Route::post('/presensi/{nik}/updateprofile', [PresensiController::class, 'updateProfile']);

    // Histori
    Route::get('/presensi/histori', [PresensiController::class, 'histori']);
    Route::post('/gethistori', [PresensiController::class, 'getHistori']);

    // izin
    Route::get('/presensi/izin', [PresensiController::class, 'izin']);
    Route::get('/presensi/izin/create', [PresensiController::class, 'createIzin']);
    Route::post('/presensi/izin/store', [PresensiController::class, 'storeIzin']);
});


Route::middleware('auth:user')->group(function () {
    Route::get('/admin/logout', [AuthController::class, 'logoutAdmin']);
    Route::get('/admin/dashboard', [DashboardController::class, 'dashboardAdmin']);

    // Karyawan
    Route::get('/karyawan', [KaryawanController::class, 'index']);
});
