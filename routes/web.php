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

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/halaman-akses', function () {
    return view('Pages.HalamanNoAkses');
});

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'authenticating'])->name('login.proses');
Route::get('registrasi', [AuthController::class, 'registrasi'])->name('registrasi');
Route::post('registrasi-store', [AuthController::class, 'store'])->name('registrasi.store');


Route::middleware('auth')->group(function () {
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/user', [AuthController::class, 'user'])->name('user');
    Route::put('/user-update/{slug}', [AuthController::class, 'update'])->name('user.update');
    Route::delete('/user-destroy/{slug}', [AuthController::class, 'destroy'])->name('user.destroy');
    Route::get('/user-disetujui/{slug}', [AuthController::class, 'setujui'])->name('user.disetujui');
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::middleware('only_admin_or_hrd')->group(function () {
        Route::get('/list-jabatan', [JabatanController::class, 'index'])->name('jabatan.list');
        Route::post('/jabatan-store', [JabatanController::class, 'store'])->name('jabatan.store');
        Route::put('/jabatan-update/{slug}', [JabatanController::class, 'update'])->name('jabatan.update');
        Route::delete('/jabatan/{slug}', [JabatanController::class, 'destroy'])->name('jabatan.destroy');

        Route::get('/list-bjs-kesehatan', [BPJSkesehatanController::class, 'index'])->name('bpjsKesehatan');
        Route::post('/bjs-kesehatan-store', [BPJSkesehatanController::class, 'store'])->name('bpjsKesehatan.store');
        Route::put('/bjs-kesehatan-update/{slug}', [BPJSkesehatanController::class, 'update'])->name('bpjsKesehatan.update');
        Route::delete('/bjs-kesehatan-destroy/{slug}', [BPJSkesehatanController::class, 'destroy'])->name('bpjsKesehatan.destroy');

        Route::get('/list-bjs-ketenaga-kerjaan', [BPJSketenagakerjaanController::class, 'index'])->name('bpjs-ketenaga-kerjaan');
        Route::post('/bjs-ketenaga-kerjaan-store', [BPJSketenagakerjaanController::class, 'store'])->name('bpjs-ketenaga.stroe');
        Route::put('/bjs-ketenaga-kerjaan-update/{slug}', [BPJSketenagakerjaanController::class, 'update'])->name('bpjs-ketenaga.update');
        Route::delete('/bjs-ketenaga-kerjaan-destroy/{slug}', [BPJSketenagakerjaanController::class, 'destroy'])->name('bpjs-ketenaga.destroy');

        Route::get('/karyawan', [KarywanController::class, 'index'])->name('karyawan');
        Route::get('/karyawan-add', [KarywanController::class, 'add'])->name('karyawan.add');
        Route::post('/karyawan-store', [KarywanController::class, 'store'])->name('karyawan.store');
        Route::get('/karyawan-edit/{slug}', [KarywanController::class, 'edit'])->name('karyawan.edit');
        Route::put('/karyawan-update/{slug}', [KarywanController::class, 'update'])->name('karyawan.update');
        Route::delete('/karyawan-destroy/{slug}', [KarywanController::class, 'destroy'])->name('karyawan.destroy');

        Route::get('/cuti', [CutiController::class, 'index'])->name('cuti');
        Route::get('/cuti-profile/{slug}', [CutiController::class, 'profile'])->name('cuti.profile');
        Route::get('/cuti-disetujui/{slug}', [CutiController::class, 'disetujui'])->name('cuti.disetujui');
        Route::get('/cuti-ditolak/{slug}', [CutiController::class, 'ditolak'])->name('cuti.ditolak');
        Route::post('/cuti-store', [CutiController::class, 'store'])->name('cuti.store');
        Route::put('/cuti-update/{slug}', [CutiController::class, 'update'])->name('cuti.update');
        Route::delete('/cuti-destroy/{slug}', [CutiController::class, 'destroy'])->name('cuti.destroy');
    });

    Route::get('/ajukan-cuti', [UserController::class, 'index'])->name('ajukan.cuti');
    Route::delete('/ajukan-cuti-destroy/{slug}', [UserController::class, 'destroy'])->name('ajukan.destroy');
});
