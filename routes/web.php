<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VisitController;
use App\Http\Controllers\GuestVisitController;
use App\Http\Controllers\MasterController;

// ==========================================
// ROUTE PUBLIK - Form Tamu Mandiri
// ==========================================
Route::get('/daftar', [GuestVisitController::class, 'showForm'])->name('tamu.form');
Route::post('/daftar', [GuestVisitController::class, 'store'])->name('tamu.store');
Route::get('/daftar/sukses/{id}', [GuestVisitController::class, 'sukses'])->name('tamu.sukses');
Route::post('/daftar/sukses/{id}/feedback', [GuestVisitController::class, 'storeFeedback'])->name('tamu.feedback');

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

    // ==========================================
    // MASTER DATA
    // ==========================================
    // Lokasi
    Route::get('/master/lokasi',          [MasterController::class, 'locations'])->name('master.locations');
    Route::post('/master/lokasi',         [MasterController::class, 'storeLocation'])->name('master.locations.store');
    Route::delete('/master/lokasi/{id}',  [MasterController::class, 'destroyLocation'])->name('master.locations.destroy');

    // Departemen
    Route::get('/master/departemen',         [MasterController::class, 'departments'])->name('master.departments');
    Route::post('/master/departemen',        [MasterController::class, 'storeDepartment'])->name('master.departments.store');
    Route::delete('/master/departemen/{id}', [MasterController::class, 'destroyDepartment'])->name('master.departments.destroy');

    // Role
    Route::get('/master/role',         [MasterController::class, 'roles'])->name('master.roles');
    Route::post('/master/role',        [MasterController::class, 'storeRole'])->name('master.roles.store');
    Route::delete('/master/role/{id}', [MasterController::class, 'destroyRole'])->name('master.roles.destroy');

    // Ruangan
    Route::get('/master/ruangan',         [MasterController::class, 'rooms'])->name('master.rooms');
    Route::post('/master/ruangan',        [MasterController::class, 'storeRoom'])->name('master.rooms.store');
    Route::delete('/master/ruangan/{id}', [MasterController::class, 'destroyRoom'])->name('master.rooms.destroy');

    // Kategori Tamu
    Route::get('/master/kategori-tamu',         [MasterController::class, 'guestCategories'])->name('master.guest-categories');
    Route::post('/master/kategori-tamu',        [MasterController::class, 'storeGuestCategory'])->name('master.guest-categories.store');
    Route::delete('/master/kategori-tamu/{id}', [MasterController::class, 'destroyGuestCategory'])->name('master.guest-categories.destroy');

    // Keperluan Kunjungan
    Route::get('/master/keperluan',         [MasterController::class, 'visitPurposes'])->name('master.visit-purposes');
    Route::post('/master/keperluan',        [MasterController::class, 'storeVisitPurpose'])->name('master.visit-purposes.store');
    Route::delete('/master/keperluan/{id}', [MasterController::class, 'destroyVisitPurpose'])->name('master.visit-purposes.destroy');

    // Blacklist
    Route::get('/master/blacklist',         [MasterController::class, 'blacklist'])->name('master.blacklist');
    Route::post('/master/blacklist',        [MasterController::class, 'storeBlacklist'])->name('master.blacklist.store');
    Route::delete('/master/blacklist/{id}', [MasterController::class, 'destroyBlacklist'])->name('master.blacklist.destroy');
});
