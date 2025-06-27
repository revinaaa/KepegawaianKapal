<?php

namespace App\Http\Controllers;

use App\Models\Cuti;
use App\Models\Karyawan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class CutiController extends Controller
{
    public function index(Request $request)
{
    $karyawans = Karyawan::select('nik', 'nama')->get();
    $search = $request->search;

    // Hitung jumlah cuti total
    $jumlahCuti = Cuti::count();

    // Query dasar
    $query = Cuti::with('karyawan');

    // Tambahkan filter jika ada keyword pencarian
    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->whereHas('karyawan', function ($q2) use ($search) {
                $q2->where('nama', 'like', '%' . $search . '%')
                   ->orWhere('nik', 'like', '%' . $search . '%');
            })
            ->orWhere('jenis_cuti', 'like', '%' . $search . '%')
            ->orWhere('status', 'like', '%' . $search . '%');
        });
    }

    // Filter berdasarkan role
    if (auth()->user()->role && in_array(auth()->user()->role->id, [1, 2])) {
        $cutis = $query->get();
    } else {
        $cutis = $query->where('user_nik', auth()->user()->nik)->get();
    }

    return view('Pages.Cuti', compact('cutis', 'karyawans', 'jumlahCuti'));
}


    public function profile($slug)
    {
        $cuti = Cuti::with(['karyawan.jabatan'])->where('slug', $slug)->firstOrFail();
        $user = auth()->user();

        if ($user->role && in_array($user->role->id, [1, 2]) || $cuti->user_id === $user->id) {
            return view('Pages.Karyawan-Profile', compact('cuti'));
        }

        abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
    }

    public function store(Request $request)
{
    $request->validate([
        'nik' => 'required|exists:karyawans,nik',
        'jenis_cuti' => 'required|string',
        'tanggal_mulai' => 'required|date',
        'tanggal_akhir' => 'required|date|after_or_equal:tanggal_mulai',
        'lampiran' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
    ]);

    $lampiranPath = null;
    if ($request->hasFile('lampiran')) {
        $path = $request->file('lampiran')->store('lampiran_cuti', 'public');
        $lampiranPath = basename($path); // hanya nama file
    }

    $cuti = new Cuti();
    $cuti->slug = Str::uuid();
    $cuti->nik = $request->nik;
    $cuti->user_nik = $request->nik; // atau sesuai logika kamu
    $cuti->jenis_cuti = $request->jenis_cuti;
    $cuti->tanggal_mulai = $request->tanggal_mulai;
    $cuti->tanggal_akhir = $request->tanggal_akhir;
    $cuti->lampiran = $lampiranPath;
    $cuti->status = 'proses';
    $cuti->save(); // ✅ pastikan ini pakai titik koma

    return redirect()->back()->with('success', 'Data cuti berhasil ditambahkan.');
}


    public function update(Request $request, $slug)
    {
        $cuti = Cuti::where('slug', $slug)->firstOrFail();

        $validated = $request->validate([
            'user_nik' => 'required|exists:karyawans,nik',
            'jenis_cuti' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_mulai',
            'status' => 'nullable|in:ditolak,proses,diterima',
        ]);

        // Handle file upload saat update
        if ($request->hasFile('lampiran')) {
            $validated['lampiran'] = $request->file('lampiran')->store('lampiran_cuti', 'public');
        }

        if ($cuti->user_nik !== $validated['user_nik']) {
            $karyawan = Karyawan::where('nik', $validated['user_nik'])->firstOrFail();
            $validated['slug'] = Str::slug($karyawan->nama) . '-' . Str::random(6);
            $validated['nik'] = $validated['user_nik'];
        }

        $validated['status'] = $validated['status'] ?? 'proses';

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

public function unduhPDF($slug)
{
    $cuti = Cuti::where('slug', $slug)->with(['karyawan.jabatan'])->firstOrFail();

    $logoPath = public_path('storage/logo/PT_Masada_Jaya_Lines.png');
    $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));

    $pdf = Pdf::loadView('Exports.cuti_pdf', compact('cuti', 'logoBase64'))
        ->setPaper('a4', 'portrait');

    return $pdf->download('cuti_' . $cuti->slug . '.pdf');
}

}