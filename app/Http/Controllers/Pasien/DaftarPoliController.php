<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\DaftarPoli;
use App\Models\Pasien;
use App\Models\JadwalPeriksa;
use Illuminate\Http\Request;

class DaftarPoliController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil data daftar poli hanya milik pasien yang login
        $pasienId = session('pasien_id'); // Ambil ID pasien dari session
        if (!$pasienId) {
            return redirect()->route('pasien.loginForm')->withErrors(['error' => 'Anda harus login terlebih dahulu.']);
        }

        $daftarPoli = DaftarPoli::where('id_pasien', $pasienId)->with(['jadwalPeriksa.dokter'])->get();

        return view('pasien.daftar.index', compact('daftarPoli'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ambil ID pasien dari session
        $pasienId = session('pasien_id');
        if (!$pasienId) {
            return redirect()->route('pasien.loginForm')->withErrors(['error' => 'Anda harus login terlebih dahulu.']);
        }

        // Ambil jadwal periksa yang tersedia
        $jadwalPeriksa = JadwalPeriksa::with('dokter')->get();

        return view('pasien.daftar.create', compact('jadwalPeriksa', 'pasienId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_jadwal' => 'required|exists:jadwal_periksa,id',
            'keluhan' => 'required|string|max:255',
        ]);

        $pasienId = session('pasien_id'); // Ambil ID pasien dari session
        if (!$pasienId) {
            return redirect()->route('pasien.loginForm')->withErrors(['error' => 'Anda harus login terlebih dahulu.']);
        }

        // Buat nomor antrian
        $lastAntrian = DaftarPoli::where('id_jadwal', $request->id_jadwal)->max('no_antrian');
        $noAntrian = $lastAntrian ? $lastAntrian + 1 : 1;

        DaftarPoli::create([
            'id_pasien' => $pasienId,
            'id_jadwal' => $request->id_jadwal,
            'keluhan' => $request->keluhan,
            'no_antrian' => $noAntrian,
        ]);

        return redirect()->route('daftar.index')->with('success', 'Pendaftaran berhasil!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $daftarPoli = DaftarPoli::findOrFail($id);

        // Pastikan hanya pasien yang terkait dapat mengedit
        $pasienId = session('pasien_id');
        if ($daftarPoli->id_pasien != $pasienId) {
            return redirect()->route('daftar.index')->withErrors(['error' => 'Anda tidak memiliki izin untuk mengedit pendaftaran ini.']);
        }

        $jadwalPeriksa = JadwalPeriksa::with('dokter')->get();

        return view('pasien.daftar.edit', compact('daftarPoli', 'jadwalPeriksa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_jadwal' => 'required|exists:jadwal_periksa,id',
            'keluhan' => 'required|string|max:255',
        ]);

        $daftarPoli = DaftarPoli::findOrFail($id);

        // Pastikan hanya pasien yang terkait dapat mengupdate
        $pasienId = session('pasien_id');
        if ($daftarPoli->id_pasien != $pasienId) {
            return redirect()->route('daftar.index')->withErrors(['error' => 'Anda tidak memiliki izin untuk mengupdate pendaftaran ini.']);
        }

        $daftarPoli->update([
            'id_jadwal' => $request->id_jadwal,
            'keluhan' => $request->keluhan,
        ]);

        return redirect()->route('daftar.index')->with('success', 'Pendaftaran berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $daftarPoli = DaftarPoli::findOrFail($id);

        // Pastikan hanya pasien yang terkait dapat menghapus
        $pasienId = session('pasien_id');
        if ($daftarPoli->id_pasien != $pasienId) {
            return redirect()->route('daftar.index')->withErrors(['error' => 'Anda tidak memiliki izin untuk menghapus pendaftaran ini.']);
        }

        $daftarPoli->delete();

        return redirect()->route('daftar.index')->with('success', 'Pendaftaran berhasil dihapus!');
    }
}
