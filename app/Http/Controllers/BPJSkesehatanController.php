<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\BpjsKesehatan;
use App\Models\Karyawan;


class BPJSkesehatanController extends Controller
{

public function index()
{
    $bpjskesehatan = BpjsKesehatan::with('karyawan')->get();
    $karyawans = Karyawan::select('nik', 'nama')->orderBy('nama')->get();
    $jumlahBpjs = BpjsKesehatan::distinct('nik')->count('nik');

    return view('pages.BPJSKesehatan', compact('bpjskesehatan', 'karyawans', 'jumlahBpjs'));
}



public function store(Request $request)
{
    $request->validate([
        'nik' => 'required|exists:karyawans,nik',
        'no_kartu' => 'required|string|max:50|unique:bpjs_kesehatans,no_kartu',
        'kelas_rawat' => 'required|in:Kelas 1,Kelas 2,Kelas 3',
        'tanggal_daftar' => 'required|date',
        'status_bpjs' => 'required|in:Aktif,Nonaktif',
    ]);

    $karyawan = Karyawan::where('nik', $request->nik)->first();

    BpjsKesehatan::create([
        'nik' => $request->nik,
        'no_kartu' => $request->no_kartu,
        'slug' => Str::slug($karyawan->nama . '-' . uniqid()),
        'nama' => $karyawan->nama, // Otomatis ambil dari relasi
        'kelas_rawat' => $request->kelas_rawat,
        'tanggal_daftar' => $request->tanggal_daftar,
        'status_bpjs' => $request->status_bpjs,
    ]);

    return redirect()->back()->with('success', 'Data BPJS berhasil ditambahkan.');
}



public function update(Request $request, $slug)
{
    $request->validate([
        'no_kartu' => 'required|string|max:50',
        'nik' => 'required|exists:karyawans,nik',
        'kelas_rawat' => 'required|in:Kelas 1,Kelas 2,Kelas 3',
        'tanggal_daftar' => 'required|date',
        'status_bpjs' => 'required|in:Aktif,Nonaktif',
    ]);

    $bpjs = BpjsKesehatan::where('slug', $slug)->firstOrFail();
    $karyawan = Karyawan::where('nik', $request->nik)->first(); // Tambahkan ini

    $bpjs->update([
        'nik' => $request->nik,
        'no_kartu' => $request->no_kartu,
        'slug' => Str::slug($karyawan->nama . '-' . uniqid()),
        'nama' => $karyawan->nama,
        'kelas_rawat' => $request->kelas_rawat,
        'tanggal_daftar' => $request->tanggal_daftar,
        'status_bpjs' => $request->status_bpjs,
    ]);

    return redirect()->back()->with('success', 'Data BPJS berhasil diperbarui.');
}


    public function destroy($slug)
    {
        $bpjs = BpjsKesehatan::where('slug', $slug)->firstOrFail();

        $bpjs->delete();

        return redirect()->back()->with('success', 'Data BPJS berhasil dihapus.');
    }
}
