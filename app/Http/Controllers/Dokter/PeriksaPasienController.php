<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\DaftarPoli;
use App\Models\Periksa;
use App\Models\DetailPeriksa;
use App\Models\Obat;
use Illuminate\Http\Request;

class PeriksaPasienController extends Controller
{
    // Tampilan daftar poli
    public function index()
    {
        $daftarPoli = DaftarPoli::with(['pasien', 'periksa'])
            ->whereHas('jadwalPeriksa', function($query) {
                $query->where('id_dokter', session('dokter_id'));
            })
            ->get();

        return view('dokter.periksa.index', compact('daftarPoli'));
    }

    // Tampilan buat periksa
    public function create($id)
    {
        $daftarPoli = DaftarPoli::with(['pasien', 'jadwalPeriksa'])
            ->findOrFail($id);
        $obatList = Obat::where('stok', '>', 0)->get();

        return view('dokter.periksa.create', compact('daftarPoli', 'obatList'));
    }

    // Simpan database
    public function store(Request $request)
    {
        $request->validate([
            'id_daftar_poli' => 'required',
            'tgl_periksa' => 'required|date',
            'catatan' => 'required',
            'obat_id' => 'required|array',
            'obat_id.*' => 'exists:obat,id',
            'jumlah' => 'required|array',
            'jumlah.*' => 'required|integer|min:1',
            'biaya_periksa' => 'required|numeric|min:150000'
        ]);

        try {
            // Create periksa 
            $periksa = new Periksa([
                'id_daftar_poli' => $request->id_daftar_poli,
                'tgl_periksa' => $request->tgl_periksa,
                'catatan' => $request->catatan,
                'biaya_periksa' => $request->biaya_periksa,
            ]);
            $periksa->save();

            // detail_periksa dan update obat stock
            foreach($request->obat_id as $index => $obatId) {
                $obat = Obat::find($obatId);
                $jumlah = $request->jumlah[$index];

                // Check stock
                if($obat->stok < $jumlah) {
                    throw new \Exception("Stok obat {$obat->nama_obat} tidak mencukupi");
                }

                //  detail periksa
                $detailPeriksa = new DetailPeriksa([
                    'id_periksa' => $periksa->id,
                    'id_obat' => $obatId,
                    'jumlah' => $jumlah
                ]);
                $detailPeriksa->save();

                // Update stock
                $obat->stok -= $jumlah;
                $obat->save();
            }

            return redirect()->route('dokter.periksa.index')
                ->with('success', 'Data pemeriksaan berhasil disimpan');

        } catch (\Exception $e) {
            if (isset($periksa) && $periksa->id) {
                $periksa->detailPeriksa()->delete();
                $periksa->delete();
            }

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    // Tampil detail
    public function show($id)
    {
        $periksa = Periksa::with(['daftarPoli.pasien', 'detailPeriksa.obat'])
            ->findOrFail($id);

        return view('dokter.periksa.show', compact('periksa'));
    }

    // Hapus (soft delete)
    public function destroy($id)
    {
        try {
            $periksa = Periksa::findOrFail($id);

            // Return medicine stock
            foreach($periksa->detailPeriksa as $detail) {
                $obat = $detail->obat;
                $obat->stok += $detail->jumlah;
                $obat->save();
            }

            // Delete related records
            $periksa->detailPeriksa()->delete();
            $periksa->delete();

            return redirect()->route('dokter.periksa.index')
                ->with('success', 'Data pemeriksaan berhasil dihapus');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }
}
