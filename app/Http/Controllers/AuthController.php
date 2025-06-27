<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Karyawan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function login()
    {
        return view('Pages.Login');
    }

    public function registrasi()
    {
        $roles = Role::all();
        return view('Pages.Registrasi', compact('roles'));
    }

    public function authenticating(Request $request)
    {
        $credentials = $request->validate([
            'name' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            if (Auth::user()->status !== 'active') {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect('/login')->with([
                    'status' => 'failed',
                    'message' => 'Akun Anda belum aktif. Silakan hubungi admin.'
                ]);
            }

            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return redirect('/login')->with([
            'status' => 'failed',
            'message' => 'Username atau Password salah.'
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|unique:users,nik',
            'name' => 'required|string|max:255|unique:users,name',
            'email' => 'required|email|max:100|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role_id' => 'required|exists:roles,id',
            'status' => 'required|in:active,inactive',
        ]);

        $newName = null;
        if ($request->hasFile('foto')) {
            $extension = $request->file('foto')->getClientOriginalExtension();
            $newName = $request->name . '-' . now()->timestamp . '.' . $extension;
            $request->file('foto')->storeAs('cover', $newName, 'public');
        }

        $user = User::create([
            'nik' => $request->nik,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
            'status' => 'active',
            'slug' => Str::slug($request->name) . '-' . Str::random(6),
        ]);
    Karyawan::create([
                'nik' => $request->nik,
                'nama' => $request->nama,
                'user_nik' => $user->nik, 
                'email' => $request->email,
                'foto' => $newName,
                'area_kerja' => $request->area_kerja,
                'pendidikan' => $request->pendidikan,
                'doh' => $request->doh,
                'id_jabatan' => $request->id_jabatan,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'usia' => $request->usia,
                'no_telepon' => $request->no_telepon,
                'golongan_darah' => $request->golongan_darah,
                'jenis_kelamin' => $request->jenis_kelamin,
                'agama' => $request->agama,
                'alamat' => $request->alamat,
                'nama_kapal' => $request->nama_kapal,
                'jenis_bank' => $request->jenis_bank,
                'no_akun_bank' => $request->no_akun_bank,
                'nama_akun_bank' => $request->nama_akun_bank,
                'kode_pajak' => $request->kode_pajak,
                'no_kk' => $request->no_kk,
                'nama_ibu' => $request->nama_ibu,
                'nik_ibu' => $request->nik_ibu,
                'pendidikan'=>$request->pendidikan,
                'status_keluarga'=>$request->status_keluarga,

                // Keluarga
                'nama_istri' => $request->nama_istri,
                'nik_istri' => $request->nik_istri,
                'nama_anak_pertama' => $request->nama_anak_pertama,
                'nik_anak_pertama' => $request->nik_anak_pertama,
                'nama_anak_kedua' => $request->nama_anak_kedua,
                'nik_anak_kedua' => $request->nik_anak_kedua,
                'nama_anak_ketiga' => $request->nama_anak_ketiga,
                'nik_anak_ketiga' => $request->nik_anak_ketiga,


                // Optional lainnya
                'no_telepon_darurat' => $request->no_telepon_darurat,
                'slug' => Str::slug($request->nama) . '-' . Str::random(5),
            ]);
    
        return redirect()->route('karyawan')->with([
            'status' => 'success',
            'message' => 'Registrasi berhasil! Harap menunggu konfirmasi admin.'
        ]);
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'nik' => 'required|unique:users,nik',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role_id' => 'required|exists:roles,id',
            'status' => 'required|in:active,inactive',
        ]);

        User::create([
            'nik' => $request->nik,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'slug' => Str::slug($request->name) . '-' . Str::random(6),
            'status' => $request->status,
            'role_id' => $request->role_id,
        ]);

        return redirect()->route('user')->with('success', 'User berhasil ditambahkan.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    public function user()
    {
        $roles = Role::all();
        $users = User::all();
        return view('Pages.User', compact('users', 'roles'));
    }

    public function setujui($slug)
    {
        $user = User::where('slug', $slug)->firstOrFail();
        $user->status = 'active';
        $user->save();

        return redirect()->back()->with('success', "User {$user->name} berhasil diaktifkan.");
    }

    public function update(Request $request, $slug)
    {
        $user = User::where('slug', $slug)->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role_id' => 'required|exists:roles,id',
            'status' => 'required|in:active,inactive',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => $request->role_id,
            'status' => $request->status,
            'slug' => Str::slug($request->name) . '-' . $user->id,
        ]);

        return redirect()->route('user')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy($slug)
    {
        $user = User::where('slug', $slug)->firstOrFail();
        $user->delete();

        return redirect()->route('user')->with('success', "User {$user->name} berhasil dihapus.");
    }

    public function showForgotPasswordForm()
    {
        return view('pages.lupa-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with('success', 'Link reset berhasil dikirim ke email Anda.')
            : back()->withErrors(['email' => __($status)]);
    }

    public function showResetForm($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|confirmed|min:6',
            'token' => 'required'
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', 'Password berhasil direset.')
            : back()->withErrors(['email' => [__($status)]]);
    }
    public function destroyUserAndKaryawan($userId, $karyawanSlug)
{
    DB::beginTransaction();

    try {
        // Hapus user berdasarkan ID
        $user = User::findOrFail($userId);
        $user->delete();

        // Hapus karyawan berdasarkan slug
        $karyawan = Karyawan::where('slug', $karyawanSlug)->firstOrFail();
        $karyawan->delete();

        DB::commit();

        return response()->json(['status' => 'success', 'message' => 'User dan Karyawan berhasil dihapus.']);
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json(['status' => 'error', 'message' => 'Gagal menghapus data.'], 500);
    }
}

}
