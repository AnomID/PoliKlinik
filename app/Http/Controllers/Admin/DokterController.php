<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\Poli;
use Illuminate\Http\Request;

class DokterController extends Controller
{
     //Tampilkan daftar semua dokter.
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Query Dokter dengan eager loading poli dan penerapan pencarian
        $dokters = Dokter::with('poli')
            ->when($search, function ($query, $search) {
                return $query->where('nama', 'LIKE', "%{$search}%")
                             ->orWhere('alamat', 'LIKE', "%{$search}%");
            })
            ->orderBy('nama', 'asc') // Opsional: Mengurutkan berdasarkan nama
            ->paginate(10); // Menampilkan 10 data per halaman

        // Mengirim data ke view dengan parameter pencarian
        return view('admin.dokter.index', compact('dokters', 'search'));
    }

     //Tampilkan form untuk membuat dokter baru.
    public function create()
    {
        $polis = Poli::all();
        return view('admin.dokter.create', compact('polis'));
    }

     //Simpan dokter baru ke database.
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:500',
            'no_hp' => 'required|string|max:20',
            'id_poli' => 'required|exists:poli,id',
        ]);

        Dokter::create($request->all());

        return redirect()->route('admin.dokter.index')
                         ->with('success', 'Dokter berhasil ditambahkan.');
    }

     // Tampilkan detail dokter.
    public function show(Dokter $dokter)
    {
        return view('admin.dokter.show', compact('dokter'));
    }


     // Tampilkan form untuk mengedit dokter.
    public function edit(Dokter $dokter)
    {
        $polis = Poli::all();
        return view('admin.dokter.edit', compact('dokter', 'polis'));
    }

     //Update dokter di database.
    public function update(Request $request, Dokter $dokter)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:500',
            'no_hp' => 'required|string|max:20',
            'id_poli' => 'required|exists:poli,id',
        ]);

        $dokter->update($request->all());

        return redirect()->route('admin.dokter.index')
                         ->with('success', 'Dokter berhasil diperbarui.');
    }


    // Hapus dokter dari database.
    public function destroy(Dokter $dokter)
    {
        $dokter->delete();

        return redirect()->route('admin.dokter.index')
                         ->with('success', 'Dokter berhasil dihapus.');
    }
}
