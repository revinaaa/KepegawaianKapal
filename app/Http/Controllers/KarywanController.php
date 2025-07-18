<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\Jabatan;
use App\Models\Karyawan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\BpjsKesehatan;
use App\Models\BpjsKetenagakerjaan;
use App\Models\User;
use App\Models\Role;
use Barryvdh\DomPDF\Facade\Pdf;


class KarywanController extends Controller
{
public function index(Request $request)
{
    $query = Karyawan::with('jabatan'); // pastikan eager loading jabatan

    if ($request->has('search') && $request->search != '') {
        $search = $request->search;

        $query->where(function ($q) use ($search) {
            $q->where('nik', 'like', '%' . $search . '%')
              ->orWhere('nama', 'like', '%' . $search . '%')
              ->orWhere('tanggal_lahir', 'like', '%' . $search . '%')
              ->orWhere('no_telepon', 'like', '%' . $search . '%')
              ->orWhereHas('jabatan', function ($j) use ($search) {
                  $j->where('nama', 'like', '%' . $search . '%');
              });
        });
    }

    $karyawans = $query->get();
    $jumlahKaryawan = $karyawans->count();

    return view('Pages.Karyawan', compact('karyawans', 'jumlahKaryawan'));
}
    public function add()
    {
        $jabatans = Jabatan::select('id', 'nama')->orderBy('nama')->get();
        // $bpjsKesehatan = BpjsKesehatan::select('id', 'no_kartu', 'nama')->orderBy('nama')->get();
          $bpjsKesehatan = BpjsKesehatan::select('id', 'no_kartu')->orderBy('no_kartu')->get();
        // $bpjsKetenagakerjaan = BpjsKetenagakerjaan::select('id', 'no_kartu', 'nama')->orderBy('nama')->get();
        $bpjsKetenagakerjaan = BpjsKetenagakerjaan::select('id', 'no_kartu')->orderBy('no_kartu')->get();
        $users = User::doesntHave('karyawan')->orderBy('name')->get();
        $roles = Role::all();

        return view('Pages.Karyawan-Tambah', compact(
            'jabatans',
            'bpjsKesehatan',
            'bpjsKetenagakerjaan',
            'users',
            'roles'
        ));
    }

public function store(Request $request)
{
    
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'nama' => 'required|string|max:255',
        'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
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
        'kode_pajak' => 'nullable|string|max:30',
        'no_kk' => 'nullable|string|max:20',
        'status_keluarga' => 'required|in:Menikah,Belum Menikah',
        'nama_istri' => 'nullable|string|max:255',
        'nik_istri' => 'nullable|string|max:20',
        'nama_anak_pertama' => 'nullable|string|max:255',
        'nik_anak_pertama' => 'nullable|string|max:20',
        'nama_anak_kedua' => 'nullable|string|max:255',
        'nik_anak_kedua' => 'nullable|string|max:20',
        'nama_anak_ketiga' => 'nullable|string|max:255',
        'nik_anak_ketiga' => 'nullable|string|max:20',
        'pendidikan' => 'nullable|string|max:100',
        'usia' => 'nullable|integer',
        'no_telepon_darurat' => 'nullable|string|max:20',
        'nama_ibu' => 'nullable|string|max:255',
        'nik_ibu' => 'nullable|string|max:20',
        'alamat' => 'nullable|string|max:255',
    ]);

    // Ambil data user dari form
    $user = User::findOrFail($request->user_id);

    // Upload foto (jika ada)
    $newName = null;
    if ($request->hasFile('foto')) {
        $extension = $request->file('foto')->getClientOriginalExtension();
        $newName = $request->nama . '-' . now()->timestamp . '.' . $extension;
        $request->file('foto')->storeAs('cover', $newName, 'public');
    }

    // Data dari form
    $data = $request->only([
        'nama', 'area_kerja', 'doh', 'id_jabatan', 'nama_kapal',
        'tempat_lahir', 'tanggal_lahir', 'no_telepon', 'jenis_kelamin',
        'golongan_darah', 'agama', 'jenis_bank', 'no_akun_bank', 'nama_akun_bank',
        'kode_pajak', 'no_kk', 'status_keluarga', 'nama_istri', 'nik_istri',
        'nama_anak_pertama', 'nik_anak_pertama', 'nama_anak_kedua', 'nik_anak_kedua',
        'nama_anak_ketiga', 'nik_anak_ketiga', 'pendidikan', 'usia',
        'no_telepon_darurat', 'nama_ibu', 'nik_ibu', 'alamat',
    ]);

    // Tambahan data sistem

    $data['nik'] = $user->nik;
    $data['user_nik'] = $user->nik;
    $data['slug'] = Str::slug($request->nama . '-' . now()->timestamp);
    $data['foto'] = $newName;
    $data['email'] = $user->email;
    $data['alamat'] = $request->alamat ?? '-';

    
    // Simpan ke database   
   Karyawan::create($data);

// BpjsKesehatan::create([
//     'nik' => $data['nik'], // ambil dari karyawan yang baru disimpan
//     'no_kartu' => $request->no_kartu_kes,
//     'nama' => $request->nama_kes,
//     'kelas_rawat' => $request->kelas_rawat_kes,
//     'tanggal_daftar' => $request->tanggal_daftar_kes,
//     'status_bpjs' => $request->status_bpjs_kes,
//     'slug' => Str::slug($request->nama_kes . '-' . now()->timestamp),
// ]);

// BpjsKetenagakerjaan::create([
//     'nik' => $data['nik'], // sama dengan karyawan
//     'no_kartu' => $request->no_kartu_kerja,
//     'nama' => $request->nama_kerja,
//     'kelas_rawat' => $request->kelas_rawat_kerja,
//     'tanggal_daftar' => $request->tanggal_daftar_kerja,
//     'status_bpjs' => $request->status_bpjs_kerja,
//     'slug' => Str::slug($request->nama_kerja . '-' . now()->timestamp),
// ]);

    return redirect()->route('karyawan')->with('success', 'Karyawan berhasil ditambahkan.');
}

    public function edit($slug)
    {
        $karyawan = Karyawan::with(['bpjsKesehatan', 'bpjsKetenagakerjaan'])
            ->where('slug', $slug)->firstOrFail();

        $jabatans = Jabatan::select('id', 'nama')->orderBy('nama')->get();
        $bpjsKesehatan = BpjsKesehatan::select('id', 'no_kartu')->orderBy('no_kartu')->get();
        $bpjsKetenagakerjaan = BpjsKetenagakerjaan::select('id', 'no_kartu')->orderBy('no_kartu')->get();
        $users = User::doesntHave('karyawan')->orWhere('nik', $karyawan->user_nik)->orderBy('name')->get();
        $roles = Role::all();

        return view('Pages.Karyawan-Edit', compact(
            'karyawan',
            'jabatans',
            'bpjsKesehatan',
            'bpjsKetenagakerjaan',
            'users',
            'roles'
        ));
    }

public function update(Request $request, $slug)
{
    $karyawan = Karyawan::where('slug', $slug)->firstOrFail();

    $request->validate([
        'nama' => 'required|string|max:255',
        'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
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
        'kode_pajak' => 'nullable|string|max:30',
        'no_kk' => 'nullable|string|max:20',
        'status_keluarga' => 'required|in:Menikah,Belum Menikah',
        'nama_istri' => 'nullable|string|max:255',
        'nik_istri' => 'nullable|string|max:20',
        'nama_anak_pertama' => 'nullable|string|max:255',
        'nik_anak_pertama' => 'nullable|string|max:20',
        'nama_anak_kedua' => 'nullable|string|max:255',
        'nik_anak_kedua' => 'nullable|string|max:20',
        'nama_anak_ketiga' => 'nullable|string|max:255',
        'nik_anak_ketiga' => 'nullable|string|max:20',
        'pendidikan' => 'nullable|string|max:100',
        'usia' => 'nullable|integer',
        'no_telepon_darurat' => 'nullable|string|max:20',
        'nama_ibu' => 'nullable|string|max:255',
        'nik_ibu' => 'nullable|string|max:20',
        'alamat' => 'nullable|string|max:255',
    ]);

    // Penanganan foto baru
    $newName = $karyawan->foto;
    if ($request->hasFile('foto')) {
        // Hapus foto lama
        if ($newName && Storage::disk('public')->exists('cover/' . $newName)) {
            Storage::disk('public')->delete('cover/' . $newName);
        }

        // Simpan foto baru
        $extension = $request->file('foto')->getClientOriginalExtension();
        $newName = $request->nama . '-' . now()->timestamp . '.' . $extension;
        $request->file('foto')->storeAs('cover', $newName, 'public');
    }

    // Ambil data form
    $data = $request->only([
        'nama', 'area_kerja', 'doh', 'id_jabatan', 'nama_kapal',
        'tempat_lahir', 'tanggal_lahir', 'no_telepon', 'jenis_kelamin',
        'golongan_darah', 'agama', 'jenis_bank', 'no_akun_bank', 'nama_akun_bank',
        'kode_pajak', 'no_kk','nama_istri', 'nik_istri',
        'nama_anak_pertama', 'nik_anak_pertama', 'nama_anak_kedua', 'nik_anak_kedua',
        'nama_anak_ketiga', 'nik_anak_ketiga', 'pendidikan', 'usia',
        'no_telepon_darurat', 'nama_ibu', 'nik_ibu', 'alamat', 'status_keluarga', 
    ]);

    // Update foto & slug jika nama berubah
    $data['foto'] = $newName;
    if ($request->nama !== $karyawan->nama) {
        $data['slug'] = Str::slug($request->nama . '-' . now()->timestamp);
    }

    // Simpan update ke database
    $karyawan->update($data);

//     // Update BPJS Kesehatan
// BpjsKesehatan::updateOrCreate(
//     ['nik' => $karyawan->nik],
//     [
//         'no_kartu' => $request->no_kartu_kes,
//         'nama' => $request->nama_kes,
//         'kelas_rawat' => $request->kelas_rawat_kes,
//         'tanggal_daftar' => $request->tanggal_daftar_kes,
//         'status_bpjs' => $request->status_bpjs_kes,
//         'slug' => Str::slug($request->nama_kes . '-' . now()->timestamp),
//     ]
// );

// // Update BPJS Ketenagakerjaan
// BpjsKetenagakerjaan::updateOrCreate(
//     ['nik' => $karyawan->nik],
//     [
//         'no_kartu' => $request->no_kartu_kerja,
//         'nama' => $request->nama_kerja,
//         'kelas_rawat' => $request->kelas_rawat_kerja,
//         'tanggal_daftar' => $request->tanggal_daftar_kerja,
//         'status_bpjs' => $request->status_bpjs_kerja,
//         'slug' => Str::slug($request->nama_kerja . '-' . now()->timestamp),
//     ]
// );


    return redirect()->route('karyawan')->with('success', 'Data karyawan berhasil diperbarui.');
}


    public function destroy($slug)
    {
        $karyawan = Karyawan::where('slug', $slug)->firstOrFail();

        if ($karyawan->foto && Storage::disk('public')->exists("cover/{$karyawan->foto}")) {
            Storage::disk('public')->delete("cover/{$karyawan->foto}");
        }

        BpjsKesehatan::where('nik', $karyawan->nik)->delete();
        BpjsKetenagakerjaan::where('nik', $karyawan->nik)->delete();
        $karyawan->delete();

        return redirect()->back()->with('success', 'Data karyawan berhasil dihapus!');
    }

public function unduhPDF($nik)
{
    $karyawan = Karyawan::with(['jabatan'])->where('nik', $nik)->firstOrFail();

    // Konversi gambar logo ke base64
    $logoPath = public_path('storage/logo/PT_Masada_Jaya_Lines.png');
    $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));

    // Kirim data ke view PDF
    $pdf = Pdf::loadView('Exports.karyawan_nik', compact('karyawan', 'logoBase64'))
                ->setPaper('a4', 'portrait');

    return $pdf->download('data_karyawan_' . $karyawan->nama . '.pdf');
}

    public function destroyWithUser($userId, $slug)
    {
        $karyawan = Karyawan::where('slug', $slug)->first();
        if ($karyawan) {
            BpjsKesehatan::where('nik', $karyawan->nik)->delete();
            BpjsKetenagakerjaan::where('nik', $karyawan->nik)->delete();
            if ($karyawan->foto && Storage::disk('public')->exists("cover/{$karyawan->foto}")) {
                Storage::disk('public')->delete("cover/{$karyawan->foto}");
            }
            $karyawan->delete();
        }

        $user = User::where('nik', $userId)->first();
        if ($user) $user->delete();

        return redirect()->route('karyawan')->with('success', 'Data user dan karyawan berhasil dihapus.');
    }


}