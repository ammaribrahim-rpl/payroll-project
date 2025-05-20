<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

use App\Http\Controllers\Karyawan\DashboardController as KaryawanDashboardController;
use App\Http\Controllers\Karyawan\AbsensiController as KaryawanAbsensiController;

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\KaryawanController as AdminKaryawanController;
use App\Http\Controllers\Admin\AbsensiController as AdminAbsensiController;
use App\Http\Controllers\Admin\GajiController as AdminGajiController;


Route::get('/', function () {
    return redirect('/login'); // Atau langsung redirect ke dashboard kalau sudah login
});

// Auth Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');


// Karyawan Routes
Route::middleware(['auth', 'karyawan'])->prefix('karyawan')->name('karyawan.')->group(function () {
    Route::get('/dashboard', [KaryawanDashboardController::class, 'index'])->name('dashboard');

    Route::post('/absensi/masuk', [KaryawanAbsensiController::class, 'presensiMasuk'])->name('absensi.masuk');
    Route::post('/absensi/pulang', [KaryawanAbsensiController::class, 'presensiPulang'])->name('absensi.pulang');
    Route::get('/absensi/riwayat', [KaryawanAbsensiController::class, 'riwayat'])->name('absensi.riwayat');
});


// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Kelola Karyawan
    Route::resource('karyawan', AdminKaryawanController::class);

    // Rekap Absensi
    Route::get('/absensi/rekap', [AdminAbsensiController::class, 'rekap'])->name('absensi.rekap');
    // Bisa tambahkan CRUD Absensi jika admin boleh mengedit absensi
    // Route::resource('absensi', AdminAbsensiController::class)->except(['show']);


    // Gaji
    Route::get('/gaji', [AdminGajiController::class, 'index'])->name('gaji.index');
    Route::get('/gaji/hitung', [AdminGajiController::class, 'showFormHitung'])->name('gaji.form_hitung');
    Route::post('/gaji/hitung', [AdminGajiController::class, 'prosesHitungGaji'])->name('gaji.proses_hitung');
    Route::get('/gaji/{gaji}/slip', [AdminGajiController::class, 'cetakSlip'])->name('gaji.slip');
    // Mungkin ada route untuk update status pembayaran, etc.
});