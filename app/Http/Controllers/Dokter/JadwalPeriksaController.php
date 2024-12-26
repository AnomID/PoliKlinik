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
        $jadwalPeriksa = JadwalPeriksa::all();
        return view('dokter.jadwal.index')->with('jadwalPeriksa', $jadwalPeriksa);
    }
    public function create()
    {
        // $dokter = Dokter::all();
        $dokter = session('dokter_id');
        if (!$dokter) {
        return redirect()->route('dokter.loginForm')->withErrors(['error' => 'Anda harus login terlebih dahulu.']);
    }
        return view('dokter.jadwal.create', compact('dokter'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_dokter' => 'required',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
        ]);

        JadwalPeriksa::create($request->all());

        return redirect()->route('dokter.jadwal.index')->with('success', 'Jadwal periksa berhasil ditambahkan');
    }

    public function show($id)
    {
        $jadwalPeriksa = JadwalPeriksa::find($id);
        return view('dokter.jadwal.show')->with('jadwalPeriksa', $jadwalPeriksa);
    }
    public function edit($id)
    {
        $jadwalPeriksa = JadwalPeriksa::find($id);
        return view('dokter.jadwal.edit')->with('jadwalPeriksa', $jadwalPeriksa);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_dokter' => 'required',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
        ]);

        $jadwalPeriksa = JadwalPeriksa::find($id);
        $jadwalPeriksa->update($request->all());

        return redirect()->route('dokter.jadwal.index')->with('success', 'Jadwal periksa berhasil diupdate');
    }
}
