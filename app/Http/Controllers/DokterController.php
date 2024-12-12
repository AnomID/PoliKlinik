<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use Illuminate\Http\Request;

class DokterController extends Controller
{
    // Menampilkan form login dokter
    public function loginForm()
    {
        return view('dokter.login-dokter');
    }

    // Menampilkan halaman dashboard dokter setelah login
    public function dashboard()
    {
        return view('dokter.dashboard-dokter');

    }    public function dashboardAdmin()
    {
        return view('admin.dashboard-admin');
    }
    // Proses login dokter dan Check
    public function loginDokter(Request $request)
{
    // Validasi input
    $request->validate([
        'nama' => 'required|string',
        'alamat' => 'required|string',
    ]);

    // Mencari dokter berdasarkan nama dan alamat
    $dokter = Dokter::where('nama', $request->nama)
                    ->where('alamat', $request->alamat)
                    ->first();

    // Menambahkan aturan khusus untuk admin
    if ($request->nama == 'AnomAdmin' && $request->alamat == 'Bosidrad') {
        // Set session untuk admin
        session(['user_role' => 'admin']);
        return redirect()->route('admin.dashboard');  // Ganti 'admin.dashboard' dengan route yang sesuai
    }

    // Jika dokter ditemukan, login dokter dengan session
    if ($dokter) {
        session(['dokter_id' => $dokter->id, 'dokter_nama' => $dokter->nama]);
        return redirect()->route('dokter.dashboard');
    }

    // Jika dokter tidak ditemukan, beri pesan error
    return redirect()->route('dokter.loginForm')
                     ->withErrors(['nama' => 'Nama atau alamat tidak valid.']);
}


}
