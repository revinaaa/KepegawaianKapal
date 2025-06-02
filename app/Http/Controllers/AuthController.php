<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login()
    {
        return view('Pages.Login');
    }
    public function registrasi()
    {
        return view('Pages.Registrasi');
    }

    public function authenticating(Request $request)
    {
        $credentials = $request->validate([
            'name' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            if (Auth::user()->status != 'active') {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                Session::flash('status', 'failed');
                Session::flash('message', 'Akun anda belum aktif, silakan hubungi admin.');
                return redirect('/login');
            }

            $request->session()->regenerate();

            if (in_array(Auth::user()->role_id, [1, 2])) {
                return redirect('/');
            }

            if (Auth::user()->role_id == 3) {
                return redirect('/');
            }
        }

        Session::flash('status', 'failed');
        Session::flash('message', 'Username atau Password salah.');
        return redirect('/login');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255|unique:users',
            'password' => 'required|max:255',
            'email' => 'required|email|max:100|unique:users',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['status'] = 'inactive';

        User::create($validated);

        Session::flash('status', 'success');
        Session::flash('message', 'Berhasil register, silakan tunggu admin mengaktifkan akun Anda.');

        return redirect('registrasi');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('login');
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

        return redirect()->back()->with('success', "User {$user->name} berhasil disetujui.");
    }

    public function update(Request $request, $slug)
    {
        $user = User::where('slug', $slug)->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255',
            'role_id' => 'required|exists:roles,id',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role_id = $request->role_id;
        $user->slug = Str::slug($request->name) . '' . $user->id;

        $user->save();

        return redirect()->route('user')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy($slug)
    {
        $user = User::where('slug', $slug)->firstOrFail();
        $user->delete();

        return redirect()->route('user')->with('success', "User {$user->name} berhasil dihapus.");
    }
}
