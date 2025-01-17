<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pasien;
use Illuminate\Http\Request;

class PasienController extends Controller
{
    // Tampilan daftar semua pasien
    public function index(Request $request)
    {
        $search = $request->input('search');

        $polisens = Pasien::when($search, function ($query, $search) {
                    return $query->where('nama', 'LIKE', "%{$search}%")
                                 ->orWhere('no_rm', 'LIKE', "%{$search}%")
                                 ->orWhere('no_ktp', 'LIKE', "%{$search}%");
                })
                ->paginate(10);

        return view('admin.pasien.index', compact('polisens'));
    }

    // Tampilan detail pasien
    public function show(Pasien $pasien)
    {
        return view('admin.pasien.show', compact('pasien'));
    }

    // Tampilan form edit
    public function edit(Pasien $pasien)
    {
        return view('admin.pasien.edit', compact('pasien'));
    }

    // Tampilan form pasien bary
    public function create()
    {
        return view('admin.pasien.create');
    }

    // Generate No Rm
    private function generateNoRm()
    {
        $year = date('Y'); //  tahun sekarang
        $month = date('m'); //  tanggal sekarang
        $prefix = $year . $month; // Format: XXXXYY

        // Mencari nomor RM terakhir dengan prefix yang sama
        $lastPasien = Pasien::where('no_rm', 'like', $prefix . '-%')
                        ->orderBy('no_rm', 'desc')
                        ->first();

        if ($lastPasien) {
            // Jika sudah ada, ambil nomor urut terakhir dan tambahkan 1
            $lastNumber = intval(substr($lastPasien->no_rm, -2));
            $newNumber = str_pad($lastNumber + 1, 2, '0', STR_PAD_LEFT);
        } else {
            // Jika belum ada, mulai dari 01
            $newNumber = '01';
        }

        return $prefix . '-' . $newNumber;
    }

    public function store(Request $request)
    {
        // Validate input
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_ktp' => 'required|numeric|unique:pasien,no_ktp',
            'no_hp' => 'required|numeric',
        ]);

        // Check for existing pasien
        $existingPasien = Pasien::where('nama', $request->nama)
                                ->where('alamat', $request->alamat)
                                ->first();

        if ($existingPasien) {
            return redirect()->route('admin.pasien.create')
                             ->withErrors(['nama' => 'Nama dan Alamat sudah terdaftar.']);
        }

        // Generate new no_rm dengan format baru
        $newNoRm = $this->generateNoRm();

        // Create new pasien
        Pasien::create([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'no_ktp' => $request->no_ktp,
            'no_hp' => $request->no_hp,
            'no_rm' => $newNoRm,
        ]);

        return redirect()->route('admin.pasien.index')->with('success', 'Pasien berhasil didaftarkan!');
    }
    // Update
    public function update(Request $request, Pasien $pasien)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:500',
            'no_ktp' => 'required|string|max:20|unique:pasien,no_ktp,' . $pasien->id,
            'no_hp' => 'required|string|max:20',
            // 'no_rm' => 'required|string|max:20|unique:pasien,no_rm,' . $pasien->id,
        ]);

        $pasien->update($request->all());

        return redirect()->route('admin.pasien.index')
                         ->with('success', 'Pasien berhasil diperbarui.');
    }

    // Hapus pasien
    public function destroy(Pasien $pasien)
    {
        // Pastikan tidak ada daftar poli yang terkait dengan pasien ini sebelum menghapus
        if ($pasien->daftarPoli()->count() > 0) {
            return redirect()->route('admin.pasien.index')
                             ->with('error', 'Pasien tidak dapat dihapus karena memiliki daftar poli terkait.');
        }

        $pasien->delete();

        return redirect()->route('admin.pasien.index')
                         ->with('success', 'Pasien berhasil dihapus.');
    }
}
