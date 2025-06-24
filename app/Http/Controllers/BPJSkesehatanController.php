<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\BpjsKesehatan;

class BPJSkesehatanController extends Controller
{
    public function index()
    {
        $bpjskesehatan = BpjsKesehatan::all();
        return view('Pages.BPJSKesehatan', compact('bpjskesehatan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_kartu' => 'required|string|max:50|unique:bpjs_kesehatans,no_kartu',
            'nama' => 'required|string|max:255',
            'kelas_rawat' => 'required|in:Kelas 1,Kelas 2,Kelas 3',
            'tanggal_daftar' => 'required|date',
            'status_bpjs' => 'required|in:Aktif,Nonaktif',
        ], [
            'no_kartu.required' => 'Nomor kartu wajib diisi.',
            'no_kartu.unique' => 'Nomor kartu sudah terdaftar.',
            'nama.required' => 'Nama wajib diisi.',
            'kelas_rawat.required' => 'Kelas rawat wajib dipilih.',
            'tanggal_daftar.required' => 'Tanggal daftar wajib diisi.',
            'status_bpjs.required' => 'Status BPJS wajib dipilih.',
        ]);

        BpjsKesehatan::create([
            'no_kartu' => $request->no_kartu,
            'nama' => $request->nama,
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
            'nama' => 'required|string|max:255',
            'kelas_rawat' => 'required|in:Kelas 1,Kelas 2,Kelas 3',
            'tanggal_daftar' => 'required|date',
            'status_bpjs' => 'required|in:Aktif,Nonaktif',
        ], [
            'no_kartu.required' => 'Nomor kartu wajib diisi.',
            'nama.required' => 'Nama wajib diisi.',
            'kelas_rawat.required' => 'Kelas rawat wajib dipilih.',
            'tanggal_daftar.required' => 'Tanggal daftar wajib diisi.',
            'status_bpjs.required' => 'Status BPJS wajib dipilih.',
        ]);

        $bpjs = BpjsKesehatan::where('slug', $slug)->firstOrFail();

        $bpjs->update([
            'no_kartu' => $request->no_kartu,
            'slug' => Str::slug($request->nama . '' . uniqid()),
            'nama' => $request->nama,
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
