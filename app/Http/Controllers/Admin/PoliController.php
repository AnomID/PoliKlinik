<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Poli;
use Illuminate\Http\Request;

class PoliController extends Controller
{
    // Talpilan daftar poli
    public function index()
    {
        $polis = Poli::paginate(10);
        return view('admin.poli.index', compact('polis'));
    }

    // Tampilan form poli baru
    public function create()
    {
        return view('admin.poli.create');
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_poli' => 'required|string|max:255',
            'keterangan' => 'nullable|string|max:1000',
        ]);

        Poli::create($request->all());

        return redirect()->route('admin.poli.index')
                         ->with('success', 'Poli berhasil ditambahkan.');
    }

    // Detail Poli
    public function show(Poli $poli)
    {
        return view('admin.poli.show', compact('poli'));
    }

    // Form edit
    public function edit(Poli $poli)
    {
        return view('admin.poli.edit', compact('poli'));
    }

    // Store Edit
    public function update(Request $request, Poli $poli)
    {
        // Validasi input
        $request->validate([
            'nama_poli' => 'required|string|max:255',
            'keterangan' => 'nullable|string|max:1000',
        ]);

        $poli->update($request->all());

        return redirect()->route('admin.poli.index')
                         ->with('success', 'Poli berhasil diperbarui.');
    }

    // Hapus
    public function destroy(Poli $poli)
    {
        // Pastikan tidak ada dokter yang terkait dengan poli ini sebelum menghapus
        if ($poli->dokter()->count() > 0) {
            return redirect()->route('admin.poli.index')
                             ->with('error', 'Poli tidak dapat dihapus karena memiliki dokter terkait.');
        }

        $poli->delete();

        return redirect()->route('admin.poli.index')
                         ->with('success', 'Poli berhasil dihapus.');
    }
}
