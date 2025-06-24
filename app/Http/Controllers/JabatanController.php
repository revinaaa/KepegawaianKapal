<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    public function index()
    {
        $jabatans = Jabatan::all();
        return view('Pages.Jabatan', compact('jabatans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ], [
            'nama.required' => 'Nama jabatan wajib diisi.',
            'nama.string' => 'Nama jabatan harus berupa teks.',
            'nama.max' => 'Nama jabatan maksimal 255 karakter.',
        ]);

        Jabatan::create([
            'nama' => $request->nama,
        ]);

        return redirect()->back()->with('success', 'Jabatan berhasil ditambahkan.');
    }

    public function update(Request $request, $slug)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ], [
            'nama.required' => 'Nama jabatan wajib diisi.',
            'nama.string' => 'Nama jabatan harus berupa teks.',
            'nama.max' => 'Nama jabatan maksimal 255 karakter.',
        ]);

        $jabatan = Jabatan::where('slug', $slug)->firstOrFail();

        $jabatan->update([
            'nama' => $request->nama,
        ]);

        return redirect()->back()->with('success', 'Jabatan berhasil diperbarui.');
    }

    public function destroy($slug)
    {
        $jabatan = Jabatan::where('slug', $slug)->firstOrFail();

        $jabatan->delete();

        return redirect()->back()->with([
            'success' => 'Jabatan berhasil dihapus!',
            'hapus' => true
        ]);
    }
}
