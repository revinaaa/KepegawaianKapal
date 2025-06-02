<?php

namespace App\Http\Controllers;

use App\Models\Cuti;
use App\Models\Karyawan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class CutiController extends Controller
{
    public function index()
    {
        $karyawans = Karyawan::select('id', 'nama')->get();
        $cutis = Cuti::with(['karyawan:id,nama,slug'])->get();

        return view('Pages.Cuti', compact('cutis', 'karyawans'));
    }

    public function profile($slug)
    {
        $cuti = Cuti::with('karyawan')->where('slug', $slug)->firstOrFail();

        return view('Pages.Karyawan-Profile', compact('cuti'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_karyawan'     => 'required|exists:karyawans,id',
            'user_id'         => 'required|exists:users,id',
            'jenis_cuti'      => 'required|string|max:255',
            'tanggal_mulai'   => 'required|date',
            'tanggal_akhir'   => 'required|date|after_or_equal:tanggal_mulai',
            'alasan'          => 'required|string',
            'email'           => 'required|email|max:100',
            'status'          => 'nullable|in:ditolak,proses,diterima',
        ], [
            'id_karyawan.required'     => 'Nama karyawan wajib diisi.',
            'id_karyawan.exists'       => 'Karyawan yang dipilih tidak ditemukan.',
            'jenis_cuti.required'      => 'Jenis cuti wajib diisi.',
            'jenis_cuti.string'        => 'Jenis cuti harus berupa teks.',
            'jenis_cuti.max'           => 'Jenis cuti tidak boleh lebih dari :max karakter.',
            'tanggal_mulai.required'  => 'Tanggal mulai wajib diisi.',
            'tanggal_mulai.date'      => 'Tanggal mulai harus berupa tanggal yang valid.',
            'tanggal_akhir.required'  => 'Tanggal akhir wajib diisi.',
            'tanggal_akhir.date'      => 'Tanggal akhir harus berupa tanggal yang valid.',
            'tanggal_akhir.after_or_equal' => 'Tanggal akhir harus sama atau setelah tanggal mulai.',
            'alasan.required'          => 'Alasan cuti wajib diisi.',
            'alasan.string'            => 'Alasan harus berupa teks.',
            'email.required'           => 'Email pemohon wajib diisi.',
            'email.email'              => 'Format email tidak valid.',
            'email.max'                => 'Email tidak boleh lebih dari :max karakter.',
            'status.in'                => 'Status hanya boleh salah satu dari: ditolak, proses, diterima.',
        ]);

        $validated['status'] = $validated['status'] ?? 'proses';

        $karyawan = Karyawan::findOrFail($validated['id_karyawan']);
        $slug = Str::slug($karyawan->nama) . '-' . Str::random(6);
        $validated['slug'] = $slug;

        Cuti::create($validated);

        return redirect()->back()->with('success', 'Data cuti berhasil ditambahkan.');
    }


    public function update(Request $request, $slug)
    {
        $cuti = Cuti::where('slug', $slug)->firstOrFail();

        $validated = $request->validate([
            'id_karyawan'     => 'required|exists:karyawans,id',
            'jenis_cuti'      => 'required|string|max:255',
            'tanggal_mulai'   => 'required|date',
            'tanggal_akhir'   => 'required|date|after_or_equal:tanggal_mulai',
            'alasan'          => 'required|string',
            'email'           => 'required|email|max:100',
            'status'          => 'nullable|in:ditolak,proses,diterima',
        ], [
            'id_karyawan.required'        => 'Nama karyawan wajib dipilih.',
            'id_karyawan.exists'          => 'Karyawan yang dipilih tidak valid.',

            'jenis_cuti.required'         => 'Jenis cuti wajib diisi.',
            'jenis_cuti.string'           => 'Jenis cuti harus berupa teks.',
            'jenis_cuti.max'              => 'Jenis cuti maksimal 255 karakter.',

            'tanggal_mulai.required'      => 'Tanggal mulai wajib diisi.',
            'tanggal_mulai.date'          => 'Tanggal mulai harus berupa tanggal yang valid.',

            'tanggal_akhir.required'      => 'Tanggal akhir wajib diisi.',
            'tanggal_akhir.date'          => 'Tanggal akhir harus berupa tanggal yang valid.',
            'tanggal_akhir.after_or_equal' => 'Tanggal akhir harus sama atau setelah tanggal mulai.',

            'alasan.required'             => 'Alasan cuti wajib diisi.',
            'alasan.string'               => 'Alasan harus berupa teks.',

            'email.required'              => 'Email wajib diisi.',
            'email.email'                 => 'Format email tidak valid.',
            'email.max'                   => 'Email maksimal 100 karakter.',

            'status.in'                   => 'Status hanya boleh: ditolak, proses, atau diterima.',
        ]);

        $validated['status'] = $validated['status'] ?? 'proses';

        if ($cuti->id_karyawan != $validated['id_karyawan']) {
            $karyawan = Karyawan::findOrFail($validated['id_karyawan']);
            $slug = Str::slug($karyawan->nama) . '-' . Str::random(6);
            $validated['slug'] = $slug;
        }

        $cuti->update($validated);

        return redirect()->back()->with('success', 'Data cuti berhasil diperbarui.');
    }


    public function destroy($slug)
    {
        $cuti = Cuti::where('slug', $slug)->firstOrFail();

        $cuti->delete();

        return redirect()->route('cuti')->with('success', 'Data cuti berhasil dihapus.');
    }

    public function disetujui($slug)
    {
        $cuti = Cuti::where('slug', $slug)->firstOrFail();
        $cuti->status = 'diterima';
        $cuti->save();

        return redirect()->back()->with('success', 'Cuti disetujui.');
    }

    public function ditolak($slug)
    {
        $cuti = Cuti::where('slug', $slug)->firstOrFail();
        $cuti->status = 'ditolak';
        $cuti->save();

        return redirect()->back()->with('success', 'Cuti ditolak.');
    }

}
