<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Obat;
use Illuminate\Http\Request;

class ObatController extends Controller
{
    /**
     * Tampilkan daftar semua obat.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $obats = Obat::when($search, function ($query, $search) {
                    return $query->where('nama_obat', 'LIKE', "%{$search}%")
                                 ->orWhere('kemasan', 'LIKE', "%{$search}%");
                })
                ->paginate(10);

        return view('admin.obat.index', compact('obats'));
    }

    /**
     * Tampilkan form untuk membuat obat baru.
     */
    public function create()
    {
        return view('admin.obat.create');
    }

    /**
     * Simpan obat baru ke database.
     */
public function store(Request $request)
{
    // Validasi input
    $request->validate([
        'nama_obat' => 'required|string|max:255',
        'kemasan' => 'required|string|max:35',
        'harga' => 'required|integer|min:0',
        'stok' => 'required|integer|min:0', // Validasi stok
    ]);

    Obat::create($request->all());

    return redirect()->route('admin.obat.index')
                     ->with('success', 'Obat berhasil ditambahkan.');
}

public function update(Request $request, Obat $obat)
{
    // Validasi input
    $request->validate([
        'nama_obat' => 'required|string|max:255',
        'kemasan' => 'required|string|max:35',
        'harga' => 'required|integer|min:0',
        'stok' => 'required|integer|min:0', // Validasi stok
    ]);

    $obat->update($request->all());

    return redirect()->route('admin.obat.index')
                     ->with('success', 'Obat berhasil diperbarui.');
}
    /**
     * Tampilkan detail obat.
     */
    public function show(Obat $obat)
    {
        return view('admin.obat.show', compact('obat'));
    }

    /**
     * Tampilkan form untuk mengedit obat.
     */
    public function edit(Obat $obat)
    {
        return view('admin.obat.edit', compact('obat'));
    }
    /**
     * Hapus obat dari database.
     */
    public function destroy(Obat $obat)
    {
        // Pastikan tidak ada transaksi atau relasi lain yang terkait dengan obat ini sebelum menghapus
        // Misalnya, jika ada relasi dengan resep atau transaksi penjualan
        // Jika ada, tampilkan pesan error dan hindari penghapusan

        // Contoh:
        // if ($obat->transaksi()->count() > 0) {
        //     return redirect()->route('admin.obat.index')
        //                      ->with('error', 'Obat tidak dapat dihapus karena terkait dengan transaksi.');
        // }

        $obat->delete();

        return redirect()->route('admin.obat.index')
                         ->with('success', 'Obat berhasil dihapus.');
    }
}
