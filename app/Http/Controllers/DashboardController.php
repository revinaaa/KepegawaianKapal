<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
public function index()
{
    $user = auth()->user();

    if (in_array($user->role_id, [1, 2])) {
        // HRD atau Admin
        $jumlahKaryawan = Karyawan::count(); // Hitung semua karyawan
        $karyawans = Karyawan::with(['jabatan', 'bpjsKesehatan', 'bpjsKetenagakerjaan'])->get();

        return view('Pages.karyawan', compact('karyawans', 'jumlahKaryawan'));
    }

    // Karyawan biasa
    $karyawans = Karyawan::with(['jabatan', 'bpjsKesehatan', 'bpjsKetenagakerjaan'])
        ->where('nik', $user->nik)
        ->get();

    return view('Pages.dashboard', compact('karyawans'));
}


}
