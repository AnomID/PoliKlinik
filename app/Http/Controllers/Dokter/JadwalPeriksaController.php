<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\JadwalPeriksa;
use App\Models\Dokter;
use Illuminate\Http\Request;

class JadwalPeriksaController extends Controller
{
    public function index()
    {
        // Memuat semua jadwal termasuk yang di-soft delete
        $jadwalPeriksa = JadwalPeriksa::withTrashed()->with(['dokter.poli'])->get();
        return view('dokter.jadwal.index')->with('jadwalPeriksa', $jadwalPeriksa);
    }

    public function create()
    {
        $dokterId = session('dokter_id');
        if (!$dokterId) {
            return redirect()->route('dokter.loginForm')->withErrors(['error' => 'Anda harus login terlebih dahulu.']);
        }
        $dokter = Dokter::find($dokterId);
        if (!$dokter) {
            return redirect()->route('dokter.loginForm')->withErrors(['error' => 'Dokter tidak ditemukan.']);
        }
        return view('dokter.jadwal.create', compact('dokter'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_dokter' => 'required|integer',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
        ]);

        JadwalPeriksa::create([
            'id_dokter' => $request->id_dokter,
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
        ]);

        return redirect()->route('dokter.jadwal.index')->with('success', 'Jadwal periksa berhasil ditambahkan');
    }

    public function show()
    {
        // Implementasikan jika diperlukan
    }

    public function edit($id)
    {
        $jadwal = JadwalPeriksa::withTrashed()->findOrFail($id);
        $dokter = $jadwal->dokter;
        if (!$dokter) {
            return redirect()->route('dokter.jadwal.index')->withErrors(['error' => 'Dokter tidak ditemukan.']);
        }
        return view('dokter.jadwal.edit', compact('jadwal', 'dokter'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
        ]);

        $jadwal = JadwalPeriksa::findOrFail($id);
        $jadwal->update([
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
        ]);

        return redirect()->route('dokter.jadwal.index')->with('success', 'Jadwal periksa berhasil diperbarui');
    }

    // Nonaktifkan Jadwal
    public function destroy($id)
    {
        $jadwal = JadwalPeriksa::findOrFail($id);
        $jadwal->delete(); // Soft delete

        return redirect()->route('dokter.jadwal.index')->with('success', 'Jadwal periksa berhasil dinonaktifkan.');
    }

    // Aktifka Jadwal
    public function restore($id)
    {
        $jadwal = JadwalPeriksa::withTrashed()->findOrFail($id);

        if ($jadwal->trashed()) {
            $jadwal->restore();
            return redirect()->route('dokter.jadwal.index')->with('success', 'Jadwal periksa berhasil diaktifkan.');
        }

        return redirect()->route('dokter.jadwal.index')->with('info', 'Jadwal periksa tidak dalam keadaan terhapus.');
    }
}
