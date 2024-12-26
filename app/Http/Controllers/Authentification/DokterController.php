<?php

namespace App\Http\Controllers\Authentification;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use Illuminate\Http\Request;

class DokterController extends Controller
{
    // TODO : View
    public function loginForm()
    {
        return view('dokter.login-dokter');
    }

    public function dashboard()
    {
        return view('dokter.dashboard-dokter');
    }

    // TODO : Login Login Dokter & Check Admin
    public function loginDokter(Request $request)
    {
        // Validate input
        $request->validate([
            'nama' => 'required|string',
            'alamat' => 'required|string',
        ]);

        $dokter = Dokter::where('nama', $request->nama)
                        ->where('alamat', $request->alamat)
                        ->first();

        if ($request->nama === 'AnomAdmin' && $request->alamat === 'Bosidrad') {
            // Set session for admin
            session(['user_role' => 'admin']);
            return redirect()->route('admin.dashboard');
        }

        // Set session for dokter
        if ($dokter) {
            session(['dokter_id' => $dokter->id, 'dokter_nama' => $dokter->nama]);
            return redirect()->route('dokter.dashboard');
        }

        return redirect()->route('dokter.loginForm')
                         ->withErrors(['nama' => 'Nama atau alamat tidak valid.']);
    }


}
