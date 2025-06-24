<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Cuti;
use App\Models\Karyawan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserController extends Controller
{
    // Tampilkan daftar user
    public function indexUser()
    {
        $users = User::all();
        return view('Pages.User.index', compact('users'));
    }

    // Tampilkan form tambah user
    public function createUser()
{
    $roles = \App\Models\Role::all(); // Ambil semua data role dari database
    return view('Pages.User.create', compact('roles')); // Kirim ke Blade
}

    // Simpan user baru
    public function storeUser(Request $request)
    {
        $request->validate([
            'nik' => 'required|string|unique:users,nik',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'status' => 'required|in:active,inactive',
            'role_id' => 'required|exists:roles,id',
        ]);

        User::create([
            'nik' => $request->nik,
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'slug' => Str::slug($request->name) . '-' . Str::random(6),
            'status' => $request->status,
            'role_id' => $request->role_id,
        ]);

        return redirect()->route('user')->with('success', 'User berhasil ditambahkan.');
    }

    // Tampilkan form edit user
    public function editUser($slug)
    {
        $user = User::where('slug', $slug)->firstOrFail();
        return view('Pages.User.edit', compact('user'));
    }

    // Update data user
    public function updateUser(Request $request, $slug)
    {
        $user = User::where('slug', $slug)->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
            'status' => 'required|in:active,inactive',
            'role_id' => 'required|exists:roles,id',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->status = $request->status;
        $user->role_id = $request->role_id;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->slug = Str::slug($request->name) . '-' . Str::random(6);
        $user->save();

        return redirect()->route('user.index')->with('success', 'User berhasil diperbarui.');
    }

    // Hapus user
    public function destroyUser($slug)
    {
        $user = User::where('slug', $slug)->firstOrFail();
        $user->delete();

        return redirect()->route('user.index')->with('success', 'User berhasil dihapus.');
    }

    // Tampilkan daftar cuti milik user yang login
    public function index()
    {
        $user = Auth::user();
        $karyawans = Karyawan::all();
        $cutis = Cuti::latest()
            ->with(['karyawan', 'user'])
            ->where('user_nik', $user->nik)
            ->get();

        return view('Pages.Karyawan-Cuti', compact('cutis', 'karyawans'));
    }

    // Hapus data cuti
    public function destroy($slug)
    {
        $cuti = Cuti::where('slug', $slug)->firstOrFail();
        $cuti->delete();

        return redirect()->route('ajukan.cuti')->with('success', 'Data cuti berhasil dihapus.');
    }

    // Simpan pengajuan cuti
    public function store(Request $request)
    {
        $request->validate([
            'id_karyawan' => 'required|exists:karyawans,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'alasan' => 'required|string|max:255',
        ]);

        $user = Auth::user();

        Cuti::create([
            'user_id' => $user->id,
            'id_karyawan' => $request->id_karyawan,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'alasan' => $request->alasan,
            'slug' => Str::slug($request->alasan) . '-' . Str::random(6),
        ]);

        return redirect()->route('ajukan.cuti')->with('success', 'Pengajuan cuti berhasil dikirim.');
    }
   public function show($slug)
{
    $user = User::where('slug', $slug)->with('role')->firstOrFail();
    return view('Pages.user-detail', compact('user'));
}


}
