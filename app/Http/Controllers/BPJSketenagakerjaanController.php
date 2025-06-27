<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\BpjsKetenagakerjaan;
use App\Models\Karyawan; // <== Tambahkan ini!

class BPJSketenagakerjaanController extends Controller
{
public function index(Request $request)
{
    $search = $request->input('search');

    $bpjsKetenagakerjaan = BpjsKetenagakerjaan::with('karyawan')
        ->when($search, function ($query) use ($search) {
            $query->whereHas('karyawan', function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%");
            });
        })
        ->get();

    $karyawans = Karyawan::select('nik', 'nama')->orderBy('nama')->get();

    return view('Pages.BPJSKetenagakerjaan', compact('bpjsKetenagakerjaan', 'karyawans', 'search'));
}


    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|exists:karyawans,nik',
            'no_kartu' => 'required|string|max:50|unique:bpjs_ketenagakerjaans,no_kartu',
            'kelas_rawat' => 'required|in:Kelas 1,Kelas 2,Kelas 3',
            'tanggal_daftar' => 'required|date',
            'status_bpjs' => 'required|in:Aktif,Nonaktif',
        ]);

        $karyawan = Karyawan::where('nik', $request->nik)->first();

        BpjsKetenagakerjaan::create([
            'nik' => $request->nik,
            'no_kartu' => $request->no_kartu,
            'slug' => Str::slug($karyawan->nama . '-' . uniqid()),
            'nama' => $karyawan->nama,
            'kelas_rawat' => $request->kelas_rawat,
            'tanggal_daftar' => $request->tanggal_daftar,
            'status_bpjs' => $request->status_bpjs,
        ]);

        return redirect()->back()->with('success', 'Data BPJS Ketenagakerjaan berhasil ditambahkan.');
    }

    public function update(Request $request, $slug)
    {
        $request->validate([
            'nik' => 'required|exists:karyawans,nik',
            'no_kartu' => 'required|string|max:50',
            'kelas_rawat' => 'required|in:Kelas 1,Kelas 2,Kelas 3',
            'tanggal_daftar' => 'required|date',
            'status_bpjs' => 'required|in:Aktif,Nonaktif',
        ]);

        $bpjs = BpjsKetenagakerjaan::where('slug', $slug)->firstOrFail();
        $karyawan = Karyawan::where('nik', $request->nik)->first();

        $bpjs->update([
            'nik' => $request->nik,
            'no_kartu' => $request->no_kartu,
            'slug' => Str::slug($karyawan->nama . '-' . uniqid()),
            'nama' => $karyawan->nama,
            'kelas_rawat' => $request->kelas_rawat,
            'tanggal_daftar' => $request->tanggal_daftar,
            'status_bpjs' => $request->status_bpjs,
        ]);

        return redirect()->back()->with('success', 'Data BPJS Ketenagakerjaan berhasil diperbarui.');
    }

    public function destroy($slug)
    {
        $bpjs = BpjsKetenagakerjaan::where('slug', $slug)->firstOrFail();
        $bpjs->delete();

        return redirect()->back()->with('success', 'Data BPJS Ketenagakerjaan berhasil dihapus.');
    }
}
