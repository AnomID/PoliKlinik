<?php

namespace App\Http\Controllers\Authentification;

use App\Http\Controllers\Controller;
use App\Models\Pasien;
use Illuminate\Http\Request;

class PasienController extends Controller
{
    // TODO : View
    public function registerForm()
    {
        return view('pasien.register-pasien');
    }

    public function loginForm()
    {
        return view('pasien.login-pasien');
    }

    public function dashboard()
    {
        return view('pasien.dashboard-pasien');
    }

    // TODO : Login Pasien
    public function loginPasien(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'alamat' => 'required|string',
        ]);

        $pasien = Pasien::where('nama', $request->nama)
                        ->where('alamat', $request->alamat)
                        ->first();

        if (!$pasien) {
            return redirect()->route('pasien.loginForm')
                             ->withErrors(['nama' => 'Nama atau alamat tidak valid.']);
        }

        // Set session for pasien
        session(['pasien_id' => $pasien->id, 'pasien_nama' => $pasien->nama]);

        return redirect()->route('pasien.dashboard');
    }

    // TODO : Register Pasien
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_ktp' => 'required|numeric|unique:pasien,no_ktp',
            'no_hp' => 'required|numeric',
        ]);

        $existingPasien = Pasien::where('nama', $request->nama)
                                ->where('alamat', $request->alamat)
                                ->first();

        if ($existingPasien) {
            return redirect()->route('pasien.registerForm')
                             ->withErrors(['nama' => 'Nama dan Alamat sudah terdaftar.']);
        }

        $lastPasien = Pasien::orderBy('no_rm', 'desc')->first();
        $newNoRm = $lastPasien ? $lastPasien->no_rm + 1 : 1;

        Pasien::create([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'no_ktp' => $request->no_ktp,
            'no_hp' => $request->no_hp,
            'no_rm' => $newNoRm,
        ]);

        return redirect()->route('pasien.loginForm')->with('success', 'Pasien berhasil didaftarkan!');
    }

}
