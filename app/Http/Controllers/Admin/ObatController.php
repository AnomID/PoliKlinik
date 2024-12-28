<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Obat;
use Illuminate\Http\Request;

class ObatController extends Controller
{
    // View index
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

    // View create
    public function create()
    {
        return view('admin.obat.create');
    }

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
            'stok' => 'required|integer|min:0',
        ]);
        $obat->update($request->all());
        return redirect()->route('admin.obat.index')
        ->with('success', 'Obat berhasil diperbarui.');
    }

    public function show(Obat $obat)
    {
        return view('admin.obat.show', compact('obat'));
    }

    public function edit(Obat $obat)
    {
        return view('admin.obat.edit', compact('obat'));
    }

    public function destroy(Obat $obat)
    {
        $obat->delete();

        return redirect()->route('admin.obat.index')
                         ->with('success', 'Obat berhasil dihapus.');
    }
}
