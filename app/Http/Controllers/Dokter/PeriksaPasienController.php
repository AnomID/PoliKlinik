<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DaftarPoli;
use App\Models\Periksa;
use App\Models\DetailPeriksa;
use App\Models\Obat;

class PeriksaPasienController extends Controller
{
    public function index()
    {
        $dokter_id = session('dokter_id');

        $daftarPoli = DaftarPoli::whereHas('jadwalPeriksa', function($query) use ($dokter_id) {
            $query->where('id_dokter', $dokter_id);
        })->with(['pasien', 'periksa'])->get();

        return view('dokter.periksa.index', compact('daftarPoli'));
    }

    public function create($id)
    {
        $daftarPoli = DaftarPoli::with(['pasien', 'jadwalPeriksa.dokter'])->findOrFail($id);
        $obatList = Obat::where('stok', '>', 0)->get();

        return view('dokter.periksa.create', compact('daftarPoli', 'obatList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_daftar_poli' => 'required|exists:daftar_poli,id',
            'tgl_periksa' => 'required|date',
            'catatan' => 'required|string',
            'obat_id' => 'required|array',
            'obat_id.*' => 'required|exists:obat,id'
        ]);

        try {
            // Hitung biaya awal
            $biayaAwal = 150000; // Biaya dokter
            $totalBiayaObat = 0;

            // Periksa stok obat sebelum memproses
            foreach($request->obat_id as $obat_id) {
                $obat = Obat::find($obat_id);
                if($obat->stok <= 0) {
                    throw new \Exception("Stok obat {$obat->nama_obat} tidak mencukupi");
                }
                $totalBiayaObat += $obat->harga;
            }

            // Create Periksa record
            $periksa = Periksa::create([
                'id_daftar_poli' => $request->id_daftar_poli,
                'tgl_periksa' => $request->tgl_periksa,
                'catatan' => $request->catatan,
                'biaya_periksa' => $biayaAwal + $totalBiayaObat
            ]);

            // Create DetailPeriksa records dan update stok
            foreach($request->obat_id as $obat_id) {
                $obat = Obat::find($obat_id);

                DetailPeriksa::create([
                    'id_periksa' => $periksa->id,
                    'id_obat' => $obat_id
                ]);

                // Kurangi stok obat
                $obat->stok -= 1;
                $obat->save();
            }

            return redirect()->route('dokter.periksa.index')
                ->with('success', 'Data pemeriksaan berhasil disimpan');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }
}
