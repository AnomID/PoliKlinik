<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\Pasien;
use App\Models\Poli;
use App\Models\Obat;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Jumlah total
        $totalDokter = Dokter::count();
        $totalPasien = Pasien::count();
        $totalPoli = Poli::count();
        $totalObat = Obat::count();

        // Statistik stok obat rendah
        $obatRendah = Obat::where('stok', '<', 10)->count();

        // Grafik jumlah pasien per bulan 12 bulan terakhir
        $pasienPerBulan = Pasien::select(DB::raw('COUNT(*) as jumlah'), DB::raw('MONTH(created_at) as bulan'))
                            ->where('created_at', '>=', Carbon::now()->subYear())
                            ->groupBy('bulan')
                            ->orderBy('bulan')
                            ->get();

        //  Data  Chart.js
        $labels = [];
        $dataPasien = [];

        // Inisialisasi data nol untuk setiap bulan
        for ($i = 1; $i <= 12; $i++) {
            $labels[] = Carbon::create()->month($i)->format('F');
            $dataPasien[] = 0;
        }

        // Isi data dengan jumlah pasien per bulan
        foreach ($pasienPerBulan as $item) {
            $dataPasien[$item->bulan - 1] = $item->jumlah;
        }

        return view('admin.dashboard', compact(
            'totalDokter',
            'totalPasien',
            'totalPoli',
            'totalObat',
            'obatRendah',
            'labels',
            'dataPasien'
        ));
    }
    // View Dashboard Admin
    public function show()
    {
        return view('admin.dashboard');
    }
}
