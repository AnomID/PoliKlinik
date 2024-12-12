<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function logoutAdmin()
    {
        session()->forget(['user_role']);
        return redirect()->route('home')->with('success', 'Anda telah logout sebagai admin.');
    }

    public function logoutDokter()
    {
        session()->forget(['dokter_id', 'dokter_nama']);
        return redirect()->route('home')->with('success', 'Anda telah logout sebagai dokter.');
    }

    public function logoutPasien()
    {
        session()->forget(['pasien_id', 'pasien_nama']);
        return redirect()->route('home')->with('success', 'Anda telah logout sebagai pasien.');
    }
}
