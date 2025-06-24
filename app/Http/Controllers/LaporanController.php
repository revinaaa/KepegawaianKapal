<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\Cuti;

class LaporanController extends Controller
{
    public function index()
    {
        $karyawans = Karyawan::with('jabatan')->get();
        $jumlahKaryawan = $karyawans->count();
       $cutiPending = Cuti::where('status', 'proses')->count();
        $cutiDisetujui = Cuti::where('status', 'disetujui')->count();
        $cutiDitolak = Cuti::where('status', 'ditolak')->count();

        // Nilai default untuk filter
        $start = null;
        $end = null;
        $jumlah = null;
        $karyawanList = [];

        return view('Pages.Laporan', compact(
            'karyawans',
            'jumlahKaryawan',
            'cutiPending',
            'cutiDisetujui',
            'cutiDitolak',
            'start',
            'end',
            'jumlah',
            'karyawanList'
        ));
    }

    public function jumlahByTanggal(Request $request)
    {
        $jumlah = null;
        $karyawanList = [];

        if ($request->has(['start', 'end'])) {
            $request->validate([
                'start' => 'required|date',
                'end' => 'required|date|after_or_equal:start',
            ]);

            $karyawanList = Karyawan::with('jabatan')
                ->whereBetween('doh', [$request->start, $request->end])
                ->get();

            $jumlah = $karyawanList->count();
        }

        $jumlahKaryawan = Karyawan::count();
        $cutiPending = Cuti::where('status', 'pending')->count();
        $cutiDisetujui = Cuti::where('status', 'disetujui')->count();
        $cutiDitolak = Cuti::where('status', 'ditolak')->count();

        return view('Pages.Laporan', [
            'jumlah' => $jumlah,
            'start' => $request->start ?? null,
            'end' => $request->end ?? null,
            'jumlahKaryawan' => $jumlahKaryawan,
            'cutiPending' => $cutiPending,
            'cutiDisetujui' => $cutiDisetujui,
            'cutiDitolak' => $cutiDitolak,
            'karyawanList' => $karyawanList,
            'karyawans' => [], // untuk kompatibilitas dengan view jika dibutuhkan
        ]);
    }
}
