<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pasien;
use App\Models\Periksa;

class RiwayatController extends Controller
{
    public function index()
    {
        // Ambil semua pasien dan hitung total pemeriksaan
        $riwayatPasien = Pasien::with('daftarPoli.periksa')->get()->map(function ($pasien) {
            $pasien->total_periksa = $pasien->daftarPoli->filter(function ($daftar) {
                return $daftar->periksa !== null;
            })->count();
            return $pasien;
        });

        return view('admin.riwayat.index', compact('riwayatPasien'));
    }

    public function detail($id_pasien)
    {
        // Ambil data pasien berdasarkan id
        $pasien = Pasien::findOrFail($id_pasien);

        // Ambil riwayat pemeriksaan pasien
        $riwayatPeriksa = Periksa::whereHas('daftarPoli', function ($query) use ($id_pasien) {
            $query->where('id_pasien', $id_pasien);
        })
        ->with([
            'daftarPoli.pasien',
            'daftarPoli.jadwalPeriksa.dokter',
            'detailPeriksa.obat'
        ])
        ->orderBy('tgl_periksa', 'desc')
        ->get();

        return view('admin.riwayat.detail', compact('pasien', 'riwayatPeriksa'));
    }
}
