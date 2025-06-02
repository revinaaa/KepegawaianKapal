<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use App\Models\Karyawan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\BpjsKesehatan;
use App\Models\BpjsKetenagakerjaan;
use Illuminate\Support\Facades\Storage;

class KarywanController extends Controller
{
    public function index()
    {
        $karyawans  = Karyawan::with('jabatan', 'bpjsKesehatan', 'bpjsKetenagakerjaan')->get();

        return view('Pages.Karyawan', compact('karyawans'));
    }

    public function add()
    {
        $jabatans = Jabatan::select('id', 'nama')->get();
        $bpjsKesehatan = BpjsKesehatan::select('id', 'no_kartu', 'nama')->get();
        $bpjsKetenagakerjaan = BpjsKetenagakerjaan::select('id', 'no_kartu', 'nama')->get();

        return view('Pages.Karyawan-Tambah', compact('jabatans', 'bpjsKesehatan', 'bpjsKetenagakerjaan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'area_kerja' => 'required|string|max:255',
            'doh' => 'required|date',
            'id_jabatan' => 'required|exists:jabatans,id',
            'nama_kapal' => 'nullable|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'no_telepon' => 'required|string|max:20',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'golongan_darah' => 'nullable|in:A,B,AB,O',
            'agama' => 'required|string|max:50',
            'jenis_bank' => 'nullable|string|max:100',
            'no_akun_bank' => 'nullable|string|max:50',
            'nama_akun_bank' => 'nullable|string|max:255',
            'id_bpjs_kesehatan' => 'nullable|string|max:30',
            'id_bpjs_ketenagakerjaan' => 'nullable|string|max:30',
            'kode_pajak' => 'nullable|string|max:30',
            'no_kk' => 'nullable|string|max:20',
            'nama_istri' => 'nullable|string|max:255',
            'nik_istri' => 'nullable|string|max:20',
            'nama_anak_pertama' => 'nullable|string|max:255',
            'nik_anak_pertama' => 'nullable|string|max:20',
            'nama_anak_kedua' => 'nullable|string|max:255',
            'nik_anak_kedua' => 'nullable|string|max:20',
            'nama_anak_ketiga' => 'nullable|string|max:255',
            'nik_anak_ketiga' => 'nullable|string|max:20',
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'foto.image' => 'Foto harus berupa gambar.',
            'foto.mimes' => 'Foto harus berformat jpg, jpeg, atau png.',
            'foto.max' => 'Ukuran foto maksimal 2MB.',
            'slug.required' => 'Slug wajib diisi.',
            'slug.unique' => 'Slug sudah digunakan.',
            'area_kerja.required' => 'Area kerja wajib diisi.',
            'doh.required' => 'Tanggal mulai bekerja (DOH) wajib diisi.',
            'doh.date' => 'DOH harus berupa tanggal.',
            'id_jabatan.required' => 'Jabatan wajib dipilih.',
            'id_jabatan.exists' => 'Jabatan tidak ditemukan.',
            'tempat_lahir.required' => 'Tempat lahir wajib diisi.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'tanggal_lahir.date' => 'Tanggal lahir harus berupa tanggal.',
            'no_telepon.required' => 'No. telepon wajib diisi.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'jenis_kelamin.in' => 'Jenis kelamin hanya boleh L atau P.',
            'agama.required' => 'Agama wajib diisi.',
        ]);

        $newName = '';
        if ($request->file('image')) {
            $extension = $request->file('image')->getClientOriginalExtension();
            $newName = $request->nama . '-' . now()->timestamp . '.' . $extension;
            $request->file('image')->storeAs('cover', $newName);
        }

        $request['foto'] = $newName;

        Karyawan::create($request->all());

        return redirect()->route('karyawan')->with('success', 'Karyawan berhasil ditambahkan.');
    }

    public function edit($slug)
    {
        $jabatans = Jabatan::select('id', 'nama')->get();
        $bpjsKesehatan = BpjsKesehatan::select('id', 'no_kartu', 'nama')->get();
        $bpjsKetenagakerjaan = BpjsKetenagakerjaan::select('id', 'no_kartu', 'nama')->get();
        $karyawan = Karyawan::where('slug', $slug)->firstOrFail();

        return view('Pages.Karyawan-Edit', compact('jabatans', 'bpjsKesehatan', 'karyawan', 'bpjsKetenagakerjaan'));
    }

    public function update(Request $request, $slug)
    {
        $karyawan = Karyawan::where('slug', $slug)->firstOrFail();

        $request->validate([
            'nama' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'area_kerja' => 'required|string|max:255',
            'doh' => 'required|date',
            'id_jabatan' => 'required|exists:jabatans,id',
            'nama_kapal' => 'nullable|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'no_telepon' => 'required|string|max:20',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'golongan_darah' => 'nullable|in:A,B,AB,O',
            'agama' => 'required|string|max:50',
            'jenis_bank' => 'nullable|string|max:100',
            'no_akun_bank' => 'nullable|string|max:50',
            'nama_akun_bank' => 'nullable|string|max:255',
            'id_bpjs_kesehatan' => 'nullable|string|max:30',
            'id_bpjs_ketenagakerjaan' => 'nullable|string|max:30',
            'kode_pajak' => 'nullable|string|max:30',
            'no_kk' => 'nullable|string|max:20',
            'nama_istri' => 'nullable|string|max:255',
            'nik_istri' => 'nullable|string|max:20',
            'nama_anak_pertama' => 'nullable|string|max:255',
            'nik_anak_pertama' => 'nullable|string|max:20',
            'nama_anak_kedua' => 'nullable|string|max:255',
            'nik_anak_kedua' => 'nullable|string|max:20',
            'nama_anak_ketiga' => 'nullable|string|max:255',
            'nik_anak_ketiga' => 'nullable|string|max:20',
        ]);

        $newName = $karyawan->foto;

        if ($request->file('image')) {
            // Hapus foto lama jika ada
            if ($karyawan->foto && Storage::exists('cover/' . $karyawan->foto)) {
                Storage::delete('cover/' . $karyawan->foto);
            }

            $extension = $request->file('image')->getClientOriginalExtension();
            $newName = $request->nama . '-' . now()->timestamp . '.' . $extension;
            $request->file('image')->storeAs('cover', $newName);
        }

        if ($request->nama !== $karyawan->nama) {
            $newSlug = Str::slug($request->nama);
            $request['slug'] = $newSlug;
        }

        $data = $request->all();
        $data['foto'] = $newName;

        $karyawan->update($data);

        return redirect()->route('karyawan')->with('success', 'Data karyawan berhasil diperbarui.');
    }
    public function destroy($slug)
    {
        $karyawan = Karyawan::where('slug', $slug)->firstOrFail();

        if ($karyawan->foto && Storage::exists('cover/' . $karyawan->foto)) {
            Storage::delete('cover/' . $karyawan->foto);
        }

        $karyawan->delete();

        return redirect()->route('karyawan')->with('success', 'Data karyawan berhasil dihapus.');
    }
}
