<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VisitController;
use App\Http\Controllers\GuestVisitController;

// ==========================================
// ROUTE PUBLIK - Form Tamu Mandiri
// ==========================================
Route::get('/daftar', [GuestVisitController::class, 'showForm'])->name('tamu.form');
Route::post('/daftar', [GuestVisitController::class, 'store'])->name('tamu.store');
Route::get('/daftar/sukses/{id}', [GuestVisitController::class, 'sukses'])->name('tamu.sukses');

// ==========================================
// ROUTE SETUP - Buat akun admin pertama (HAPUS setelah digunakan!)
// ==========================================
Route::get('/setup', [AuthController::class, 'showSetup'])->name('setup');
Route::post('/setup', [AuthController::class, 'setup'])->name('setup.store');

// ==========================================
// ROUTE AUTH (Guest Only)
// ==========================================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Logout (harus login)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ==========================================
// ROUTE APLIKASI (Harus Login)
// ==========================================
Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return redirect()->route('kunjungan.index');
    });

    Route::resource('kunjungan', VisitController::class);
    Route::post('/kunjungan/{id}/mengakhiri', [VisitController::class, 'checkout'])->name('kunjungan.mengakhiri');

    // Manajemen akun admin
    Route::get('/admin/tambah-akun', [AuthController::class, 'showTambahAkun'])->name('admin.tambah-akun');
    Route::post('/admin/tambah-akun', [AuthController::class, 'tambahAkun'])->name('admin.tambah-akun.store');
    Route::get('/admin/kelola-akun', [AuthController::class, 'kelolaAkun'])->name('admin.kelola-akun');
    Route::delete('/admin/kelola-akun/{id}', [AuthController::class, 'hapusAkun'])->name('admin.hapus-akun');
});
