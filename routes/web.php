<?php

use App\Models\BpjsKetenagakerjaan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CutiController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\KarywanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BPJSkesehatanController;
use App\Http\Controllers\BPJSketenagakerjaanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Storage;


// Route root: redirect ke dashboard jika sudah login, ke login jika belum
Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

// Halaman tidak punya akses
Route::get('/halaman-akses', function () {
    return view('Pages.HalamanNoAkses');
});

// Autentikasi
Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'authenticating'])->name('login.proses');
Route::get('registrasi', [AuthController::class, 'registrasi'])->name('registrasi');
Route::post('registrasi-store', [AuthController::class, 'store'])->name('registrasi.store');


  // Tampilkan form lupa password
    Route::get('/lupa-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');

    // Proses kirim email reset
    Route::post('/lupa-password', [AuthController::class, 'sendResetLink'])->name('password.email');

    // Tampilkan form reset password berdasarkan token
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');

    // Proses reset password
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');


// Setelah login wajib auth middleware
Route::middleware('auth')->group(function () {

    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/user', [AuthController::class, 'user'])->name('user');
    Route::put('/user-update/{slug}', [AuthController::class, 'update'])->name('user.update');
    Route::delete('/user-destroy/{slug}', [AuthController::class, 'destroy'])->name('user.destroy');
    Route::get('/user-disetujui/{slug}', [AuthController::class, 'setujui'])->name('user.disetujui');
    Route::get('/cuti-profile/{slug}', [CutiController::class, 'profile'])->name('cuti.profile');

    Route::get('/cuti-unduh/{slug}', [CutiController::class, 'unduhPDF'])->name('cuti.unduh.pdf');


    // Dashboard route setelah login
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Cuti store khusus untuk karyawan
    Route::post('/cuti-store', [CutiController::class, 'store'])->name('cuti.store');

    //  Karyawan bisa lihat & hapus cuti mereka
    Route::get('/ajukan-cuti', [UserController::class, 'index'])->name('ajukan.cuti');
    Route::delete('/ajukan-cuti-destroy/{slug}', [UserController::class, 'destroy'])->name('ajukan.destroy');

    //lampiran cuti
    Route::get('/lampiran/{filename}', function ($filename) {
    $path = storage_path('app/public/lampiran_cuti/' . $filename);
    if (!file_exists($path)) abort(404);
    return response()->file($path);
    })->name('lihat.lampiran');

  
    //  ADMIN / HRD ONLY
    Route::middleware('only_admin_or_hrd')->group(function () {

        //Tambah User
        Route::post('/user-store', [AuthController::class, 'storeUser'])->name('user.store');
        Route::get('/user/{slug}', [UserController::class, 'show'])->name('user.show');

        
        // Jabatan
        Route::get('/list-jabatan', [JabatanController::class, 'index'])->name('jabatan.list');
        Route::post('/jabatan-store', [JabatanController::class, 'store'])->name('jabatan.store');
        Route::put('/jabatan-update/{slug}', [JabatanController::class, 'update'])->name('jabatan.update');
        Route::delete('/jabatan/{slug}', [JabatanController::class, 'destroy'])->name('jabatan.destroy');

        // // BPJS Kesehatan
        // Route::get('/list-bjs-kesehatan', [BPJSkesehatanController::class, 'index'])->name('bpjsKesehatan');
        // Route::post('/bjs-kesehatan-store', [BPJSkesehatanController::class, 'store'])->name('bpjsKesehatan.store');
        // Route::put('/bjs-kesehatan-update/{slug}', [BPJSkesehatanController::class, 'update'])->name('bpjsKesehatan.update');
        // Route::delete('/bjs-kesehatan-destroy/{slug}', [BPJSkesehatanController::class, 'destroy'])->name('bpjsKesehatan.destroy');

        // // BPJS Ketenagakerjaan
        // Route::get('/list-bjs-ketenaga-kerjaan', [BPJSketenagakerjaanController::class, 'index'])->name('bpjs-ketenaga-kerjaan');
        // Route::post('/bjs-ketenaga-kerjaan-store', [BPJSketenagakerjaanController::class, 'store'])->name('bpjs-ketenaga.store');
        // Route::put('/bjs-ketenaga-kerjaan-update/{slug}', [BPJSketenagakerjaanController::class, 'update'])->name('bpjs-ketenaga.update');
        // Route::delete('/bjs-ketenaga-kerjaan-destroy/{slug}', [BPJSketenagakerjaanController::class, 'destroy'])->name('bpjs-ketenaga.destroy');

        // Karyawan
        Route::get('/karyawan', [KarywanController::class, 'index'])->name('karyawan');
        Route::get('/karyawan-add', [KarywanController::class, 'add'])->name('karyawan.add');
        Route::post('/karyawan-store', [KarywanController::class, 'store'])->name('karyawan.store');
        Route::get('/karyawan-edit/{slug}', [KarywanController::class, 'edit'])->name('karyawan.edit');
        Route::put('/karyawan-update/{slug}', [KarywanController::class, 'update'])->name('karyawan.update');
        Route::delete('/karyawan-destroy/{slug}', [KarywanController::class, 'destroy'])->name('karyawan.destroy');
        
        // untuk masing masing karyawan
        Route::get('/karyawan-unduh/{nik}', [KarywanController::class, 'unduhPDF'])->name('karyawan.unduh.pdf');


        // Route untuk mengunduh data karyawan
        Route::get('/karyawan-unduh', [KarywanController::class, 'unduh'])->name('karyawan.unduh');

        // CUTI (admin/HRD)
        Route::get('/cuti', [CutiController::class, 'index'])->name('cuti');
        Route::get('/cuti-disetujui/{slug}', [CutiController::class, 'disetujui'])->name('cuti.disetujui');
        Route::get('/cuti-ditolak/{slug}', [CutiController::class, 'ditolak'])->name('cuti.ditolak');
        Route::put('/cuti-update/{slug}', [CutiController::class, 'update'])->name('cuti.update');
        Route::delete('/cuti-destroy/{slug}', [CutiController::class, 'destroy'])->name('cuti.destroy');

                // Laporan Data Karyawan dan Cuti
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan');

        Route::get('/karyawan/jumlah-by-tanggal', [LaporanController::class, 'jumlahByTanggal'])->name('karyawan.jumlahByTanggal');

         //hapus user dan data karyawan sekaligus
        
        Route::delete('/hapus-user-dan-karyawan/{userId}/{slug}', [KarywanController::class, 'destroyWithUser'])->name('hapus.karyawan.user');
    });
});
