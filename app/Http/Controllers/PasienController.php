<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use Illuminate\Http\Request;

class PasienController extends Controller
{
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

    public function loginPasien(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string',
            'alamat' => 'required|string',
        ]);

        // Mencari pasien berdasarkan nama dan alamat
        $pasien = Pasien::where('nama', $request->nama)
                        ->where('alamat', $request->alamat)
                        ->first();

        if (!$pasien) {
            return redirect()->route('pasien.loginForm')
                             ->withErrors(['nama' => 'Nama atau alamat tidak valid.']);
        }

        // Jika ditemukan, login pasien dengan session
        // Untuk login menggunakan session Laravel, Anda bisa menggunakan Auth (biasa digunakan untuk user yang memiliki kolom email)
        // Di sini kita akan menggunakan session untuk menyimpan data pasien
        session(['pasien_id' => $pasien->id, 'pasien_nama' => $pasien->nama]);

        return redirect()->route('pasien.dashboard');
    }



    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_ktp' => 'required|numeric|unique:pasien,no_ktp',
            'no_hp' => 'required|numeric',
        ]);

        // Cek Kombinasi Nama dan Alamat
        $existingPasien = Pasien::where('nama', $request->nama)
                                ->where('alamat', $request->alamat)
                                ->first();

        if ($existingPasien) {
            return redirect()->route('pasien.register')
                             ->withErrors(['nama' => 'Nama dan Alamat sudah terdaftar.']);
        }

        // Mengambil nomor rekam medis terakhir dan menambahkannya 1
        $lastPasien = Pasien::orderBy('no_rm', 'desc')->first(); // Ambil pasien terakhir berdasarkan no_rm
        $newNoRm = $lastPasien ? $lastPasien->no_rm + 1 : 1; // Jika ada pasien sebelumnya, no_rm ditambah 1, jika belum ada mulai dari 1

        // Menyimpan data pasien dengan no_rm otomatis
        Pasien::create([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'no_ktp' => $request->no_ktp,
            'no_hp' => $request->no_hp,
            'no_rm' => $newNoRm, // Menambahkan no_rm otomatis
        ]);

        return redirect()->route('pasien.register')->with('success', 'Pasien berhasil didaftarkan!');
    }
}
