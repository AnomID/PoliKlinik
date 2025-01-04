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
    // Generate No Rm
    private function generateNoRm()
    {
        $year = date('Y'); //  tahun sekarang
        $month = date('m'); //  bulan sekarang
        $prefix = $year . $month; // Format: YYYYMM

        // Mencari nomor RM terakhir dengan prefix yang sama
        $lastPasien = Pasien::where('no_rm', 'like', $prefix . '-%')
                        ->orderBy('no_rm', 'desc')
                        ->first();

        if ($lastPasien) {
            // Jika sudah ada, ambil nomor urut terakhir dan tambahkan 1
            $lastNumber = intval(substr($lastPasien->no_rm, -2));
            $newNumber = str_pad($lastNumber + 1, 2, '0', STR_PAD_LEFT);
        } else {
            // Jika belum ada, mulai dari 01
            $newNumber = '01';
        }

        return $prefix . '-' . $newNumber;
    }

       public function store(Request $request)
    {
        // Validate input
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_ktp' => 'required|numeric|unique:pasien,no_ktp',
            'no_hp' => 'required|numeric',
        ]);

        // Check for existing pasien
        $existingPasien = Pasien::where('nama', $request->nama)
                                ->where('alamat', $request->alamat)
                                ->first();

        if ($existingPasien) {
            return redirect()->route('pasien.registerForm')
                             ->withErrors(['nama' => 'Nama dan Alamat sudah terdaftar.']);
        }

        // Generate new no_rm dengan format baru
        $newNoRm = $this->generateNoRm();

        // Create new pasien
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
