<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\DaftarPoli;
use App\Models\JadwalPeriksa;
use App\Models\Poli;
use App\Models\Pasien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB; 
class DaftarPoliController extends Controller
{

    // Menampilkan daftar semua pendaftaran poli untuk pasien yang login.
public function index()
    {
        $pasien_id = session('pasien_id');

        $daftarPoli = DB::table('daftar_poli as dp')
            ->select([
                'dp.id AS daftar_poli_id',
                'p.no_rm AS no_rm',
                'poli.nama_poli AS nama_poli',
                'd.nama AS nama_dokter',
                'jp.hari AS hari',
                'jp.jam_mulai AS jam_mulai',
                'jp.jam_selesai AS jam_selesai',
                'dp.no_antrian AS no_antrian',
                'dp.keluhan AS keluhan',
            ])
            ->leftJoin('pasien AS p', 'dp.id_pasien', '=', 'p.id')
            ->leftJoin('jadwal_periksa AS jp', 'dp.id_jadwal', '=', 'jp.id')
            ->leftJoin('dokter AS d', 'jp.id_dokter', '=', 'd.id')
            ->leftJoin('poli AS poli', 'd.id_poli', '=', 'poli.id')
            ->where('dp.id_pasien', $pasien_id)
            ->get();

        return view('pasien.daftar.index', compact('daftarPoli'));
    
    }

//     class DaftarPoliController extends Controller
// {

    // Menampilkan daftar semua pendaftaran poli untuk pasien yang login.
//     public function index()
//     {
//         $pasien_id = session('pasien_id');
//         $daftarPoli = DaftarPoli::with(['pasien', 'jadwalPeriksa.dokter.poli'])
//             ->where('id_pasien', $pasien_id)
//             ->get();

//         return view('pasien.daftar.index', compact('daftarPoli'));
//     }

    // Menampilkan formulir untuk membuat pendaftaran poli baru.
public function create(Request $request)
{
    $pasien = Pasien::find(session('pasien_id'));
    $polis = Poli::all();

    $jadwals = collect();
    if ($request->has('id_poli')) {
        $jadwals = JadwalPeriksa::whereHas('dokter', function ($query) use ($request) {
            $query->where('id_poli', $request->id_poli);
        })->get();
    }

    return view('pasien.daftar.create', compact('pasien', 'polis', 'jadwals'));
}


    // Menyimpan pendaftaran poli baru ke dalam database.
    public function store(Request $request)
    {
        $request->validate([
            'id_jadwal' => 'required|exists:jadwal_periksa,id',
            'keluhan' => 'required|string',
        ]);

        $jadwalPeriksa = JadwalPeriksa::with('dokter.poli')->findOrFail($request->id_jadwal);
        $poli_id = $request->input('id_poli');

        // if ($jadwalPeriksa->dokter->poli->id != $poli_id) {
        //     return back()->withErrors(['id_jadwal' => 'Jadwal periksa yang dipilih tidak sesuai dengan poli yang dipilih.'])->withInput();
        // }

        // Generate no_antrian
        $lastAntrian = DaftarPoli::where('id_jadwal', $request->id_jadwal)->max('no_antrian');
        $noAntrian = $lastAntrian ? $lastAntrian + 1 : 1;

        DaftarPoli::create([
            'id_pasien' => session('pasien_id'),
            'id_jadwal' => $request->id_jadwal,
            'keluhan' => $request->keluhan,
            'no_antrian' => $noAntrian,
        ]);

        return redirect()->route('pasien.daftar.index')->with('success', 'Pendaftaran poli berhasil ditambahkan dengan nomor antrian ' .$noAntrian);
    }


    // Menampilkan detail pendaftaran
public function show($id)
{
    $daftarPoli = DB::table('daftar_poli as dp')
        ->select([
            'dp.id AS daftar_poli_id',
            'p.no_rm AS no_rm',
            'poli.nama_poli AS nama_poli',
            'd.nama AS nama_dokter',
            'jp.hari AS hari',
            'jp.jam_mulai AS jam_mulai',
            'jp.jam_selesai AS jam_selesai',
            'dp.no_antrian AS no_antrian',
            'dp.keluhan AS keluhan',
            'pe.tgl_periksa AS tgl_periksa',
            'pe.catatan AS catatan',
            'pe.biaya_periksa AS biaya_periksa',
        ])
        ->leftJoin('pasien AS p', 'dp.id_pasien', '=', 'p.id')
        ->leftJoin('jadwal_periksa AS jp', 'dp.id_jadwal', '=', 'jp.id')
        ->leftJoin('dokter AS d', 'jp.id_dokter', '=', 'd.id')
        ->leftJoin('poli AS poli', 'd.id_poli', '=', 'poli.id')
        ->leftJoin('periksa AS pe', 'dp.id', '=', 'pe.id_daftar_poli')
        ->where('dp.id', $id)
        ->first();

    // if (!$daftarPoli || session('pasien_id') != $id) {
    //     abort(403, 'Aksi tidak diizinkan.');
    // }

    return view('pasien.daftar.show', compact('daftarPoli'));
}


    // public function show($id)
    // {
    //     $daftarPoli = DaftarPoli::with(['pasien', 'jadwalPeriksa.dokter.poli', 'periksa'])
    //         ->findOrFail($id);

    //     // Pastikan pendaftaran poli milik pasien yang sedang login
    //     if ($daftarPoli->id_pasien != session('pasien_id')) {
    //         abort(403, 'Aksi tidak diizinkan.');
    //     }
    //     return view('pasien.daftar.show', compact('daftarPoli'));
    // }

    


    // Menampilkan formulir untuk mengedit pendaftaran poli tertentu.
    public function edit($id)
    {
        $daftarPoli = DaftarPoli::with(['jadwalPeriksa.dokter.poli'])->findOrFail($id);

        // Pastikan pendaftaran poli milik pasien yang sedang login
        if ($daftarPoli->id_pasien != session('pasien_id')) {
            abort(403, 'Aksi tidak diizinkan.');
        }

        $polis = Poli::all();
        $selectedPoliId = $daftarPoli->jadwalPeriksa->dokter->poli->id;
        $jadwalPeriksas = JadwalPeriksa::whereHas('dokter', function($query) use ($selectedPoliId) {
            $query->where('id_poli', $selectedPoliId);
        })->with('dokter')->get();

        return view('pasien.daftar.edit', compact('daftarPoli', 'polis', 'jadwalPeriksas'));
    }
    // Update data daftar poli
    public function update(Request $request, $id)
    {
        $daftarPoli = DaftarPoli::findOrFail($id);

        // Pastikan pendaftaran poli milik pasien yang sedang login
        if ($daftarPoli->id_pasien != session('pasien_id')) {
            abort(403, 'Aksi tidak diizinkan.');
        }

        $request->validate([
            'id_jadwal' => 'required|exists:jadwal_periksa,id',
            'keluhan' => 'required|string',
        ]);

        // Verifikasi bahwa jadwal_periksa sesuai dengan poli yang dipilih
        $jadwalPeriksa = JadwalPeriksa::with('dokter.poli')->findOrFail($request->id_jadwal);
        $poli_id = $request->input('id_poli');

        if ($jadwalPeriksa->dokter->poli->id != $poli_id) {
            return back()->withErrors(['id_jadwal' => 'Jadwal periksa yang dipilih tidak sesuai dengan poli yang dipilih.'])->withInput();
        }

        // Update data
        $daftarPoli->update([
            'id_jadwal' => $request->id_jadwal,
            'keluhan' => $request->keluhan,
            // 'no_antrian' => $request->no_antrian,
        ]);

        return redirect()->route('pasien.daftar.index')->with('success', 'Pendaftaran poli berhasil diperbarui.');
    }

    // Hapus pendaftaran poli
    public function destroy($id)
    {
        $daftarPoli = DaftarPoli::findOrFail($id);

        // Pastikan pendaftaran poli milik pasien yang sedang login
        if ($daftarPoli->id_pasien != session('pasien_id')) {
            abort(403, 'Aksi tidak diizinkan.');
        }

        $daftarPoli->delete();

        return redirect()->route('pasien.daftar.index')->with('success', 'Pendaftaran poli berhasil dihapus.');
    }


    // Mengambil jadwal_periksa berdasarkan poli yang dipilih (untuk AJAX).

    public function getJadwalPeriksa($poli_id)
    {
        // Log untuk debugging
        Log::info('Meminta jadwal_periksa untuk poli_id: ' . $poli_id);
        // Pastikan Poli ada
        $poli = Poli::find($poli_id);
        if (!$poli) {
        Log::error('Poli tidak ditemukan: ' . $poli_id);
        return response()->json(['error' => 'Poli tidak ditemukan'], 404);
        }
        // Ambil jadwal_periksa berdasarkan poli
        $jadwal = JadwalPeriksa::whereHas('dokter', function($query) use ($poli_id) {
            $query->where('id_poli', $poli_id);
        })->with('dokter')->get();
        Log::info('Jumlah jadwal_periksa yang ditemukan: ' . $jadwal->count());
        return response()->json($jadwal);
    }

}
