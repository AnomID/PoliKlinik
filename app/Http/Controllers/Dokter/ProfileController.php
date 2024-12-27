<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dokter; // Pastikan sudah meng-import model Dokter

class ProfileController extends Controller
{
    /**
     * Menampilkan form edit profile dokter.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        // Ambil ID dokter dari session (sesuai dengan logika yang Anda buat di middleware)
        $dokterId = session('dokter_id');

        // Pastikan datanya ada
        $dokter = Dokter::findOrFail($dokterId);

        // Tampilkan view edit
        return view('dokter.profile.edit', compact('dokter'));
    }

    /**
     * Update data profile dokter.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        // Ambil ID dokter dari session
        $dokterId = session('dokter_id');

        // Cari data dokter
        $dokter = Dokter::findOrFail($dokterId);

        // Validasi data (sesuaikan kebutuhan Anda)
        $request->validate([
            'nama'  => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'no_hp' => 'required|string|max:15',
        ]);

        // Update data
        $dokter->update([
            'nama'   => $request->nama,
            'alamat' => $request->alamat,
            'no_hp'  => $request->no_hp,
        ]);

        // Redirect ke halaman dashboard atau ke mana pun yang Anda inginkan
        return redirect()
            ->route('dokter.profile.edit')
            ->with('success', 'Profile berhasil diperbarui.');
    }
}
