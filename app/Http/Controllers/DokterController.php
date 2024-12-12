<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use Illuminate\Http\Request;

class DokterController extends Controller
{
    // Display dokter login form
    public function loginForm()
    {
        return view('dokter.login-dokter');
    }

    // Display dokter dashboard after login
    public function dashboard()
    {
        return view('dokter.dashboard-dokter');
    }

    // Display admin dashboard
    public function dashboardAdmin()
    {
        return view('admin.dashboard-admin');
    }

    // Handle dokter login
    public function loginDokter(Request $request)
    {
        // Validate input
        $request->validate([
            'nama' => 'required|string',
            'alamat' => 'required|string',
        ]);

        // Find dokter by nama and alamat
        $dokter = Dokter::where('nama', $request->nama)
                        ->where('alamat', $request->alamat)
                        ->first();

        // Special case for admin
        if ($request->nama === 'AnomAdmin' && $request->alamat === 'Bosidrad') {
            // Set session for admin
            session(['user_role' => 'admin']);
            return redirect()->route('admin.dashboard');
        }

        // If dokter found, set session
        if ($dokter) {
            session(['dokter_id' => $dokter->id, 'dokter_nama' => $dokter->nama]);
            return redirect()->route('dokter.dashboard');
        }

        // If dokter not found, redirect back with error
        return redirect()->route('dokter.loginForm')
                         ->withErrors(['nama' => 'Nama atau alamat tidak valid.']);
    }

    // Ensure poli method exists
    public function poli()
    {
        // Implement the logic for poli
        return view('dokter.poli');
    }
}
