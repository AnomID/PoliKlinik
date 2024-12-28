<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DaftarPoli;
use App\Models\Periksa;
use App\Models\DetailPeriksa;
use App\Models\Dokter;
use App\Models\Pasien;
use Illuminate\Support\Facades\DB;

class RiwayatController extends Controller
{
    public function index()
    {
        // Get session id dokter
        $dokter_id = session('dokter_id');
        // Get riwayat pasien yang mempunyai daftar poli berdasrkan jadwal periksa
        $riwayatPasien = Pasien::whereHas('daftarPoli.jadwalPeriksa', function($query) use ($dokter_id) {
                $query->where('id_dokter', $dokter_id);
            })
            ->with(['daftarPoli' => function($query) use ($dokter_id) {
                $query->whereHas('jadwalPeriksa', function($q) use ($dokter_id) {
                    $q->where('id_dokter', $dokter_id);
                });
                $query->with('periksa');
            }])
            ->get()
            ->map(function($pasien) {
                // tambah data periksa pasien
                $pasien->total_periksa = $pasien->daftarPoli->filter(function($daftar) {
                    return $daftar->periksa !== null;
                })->count();
                return $pasien;
            });

        return view('dokter.riwayat.index', compact('riwayatPasien'));
    }

    public function detail($id_pasien)
    {
        $dokter_id = session('dokter_id');

        // Get data pasien
        $pasien = Pasien::findOrFail($id_pasien);

        // Get semua data periksa berdasarkan dokter id dokter
        $riwayatPeriksa = Periksa::whereHas('daftarPoli', function($query) use ($dokter_id, $id_pasien) {
                $query->whereHas('jadwalPeriksa', function($q) use ($dokter_id) {
                    $q->where('id_dokter', $dokter_id);
                })
                ->where('id_pasien', $id_pasien);
            })
            ->with([
                'daftarPoli.pasien',
                'daftarPoli.jadwalPeriksa.dokter',
                'detailPeriksa.obat'
            ])
            ->orderBy('tgl_periksa', 'desc')
            ->get();

        return view('dokter.riwayat.detail', compact('pasien', 'riwayatPeriksa'));
    }
}
