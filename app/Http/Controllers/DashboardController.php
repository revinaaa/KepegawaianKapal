<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $karyawans  = Karyawan::with('jabatan', 'bpjsKesehatan', 'bpjsKetenagakerjaan')->get();
        return view('Pages.dashboard', compact('karyawans'));
    }
}
