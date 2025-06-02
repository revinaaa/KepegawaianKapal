<?php

namespace App\Http\Controllers;

use App\Models\Cuti;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $karyawans = Karyawan::all();

        $cutis = Cuti::latest()
            ->with(['karyawan', 'user'])
            ->where('user_id', $user->id)
            ->get();

        return view('Pages.Karyawan-Cuti', compact('cutis', 'karyawans'));
    }
    public function destroy($slug)
    {
        $cuti = Cuti::where('slug', $slug)->firstOrFail();

        $cuti->delete();

        return redirect()->route('ajukan.cuti')->with('success', 'Data cuti berhasil dihapus.');
    }
}
