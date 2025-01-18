<?php

namespace App\Http\Controllers;

use App\Models\Konsultasi;
use App\Models\Pasien;
use App\Models\Dokter;
use Illuminate\Http\Request;

class KonsultasiController extends Controller
{

    public function index()
    {
        $pasien = Pasien::find(session('pasien_id'));
    
        if (!$pasien) {
            
            return redirect()->route('login')->with('error', 'Pasien tidak ditemukan di session.');
        }
    
        $konsultasis = Konsultasi::where('id_pasien', $pasien->id)
                                 ->orWhere('id_dokter', session('dokter_id'))
                                 ->with(['pasien', 'dokter'])
                                 ->get();
    
        return view('pasien.konsultasi.index', compact('konsultasis', 'pasien'));

    }
    
    public function create()
{
    $pasien = Pasien::find(session('pasien_id'));

    // if (!$pasien) {
    //     return redirect()->route('login')->with('error', 'Pasien tidak ditemukan di session.');
    // }

    $dokter = Dokter::all();

    return view('pasien.konsultasi.create', compact('pasien', 'dokter'));
}



public function store(Request $request)
{
    $request->validate([
        'id_dokter' => 'required|exists:dokter,id',
        'subject' => 'required|string|max:30',
        'chat_note' => 'required|string|max:500',
        // 'jawaban' => 'required|string|max:500',
    ]);

    $pasien_id = session('pasien_id');
    
    if (!$pasien_id) {
        return redirect()->route('login')->with('error', 'Pasien tidak ditemukan di session.');
    }

    $dokter = Dokter::find($request->id_dokter);

    if (!$dokter) {
        return redirect()->route('pasien.konsultasi.create')->with('error', 'Dokter tidak valid.');
    }

    Konsultasi::create([
        'id_pasien' => $pasien_id,
        'id_dokter' => $request->id_dokter,
        'subject' => $request->subject,
        'chat_note' => $request->chat_note,
        'jawaban' => $request->jawaban,
    ]);

    return redirect()->route('pasien.konsultasi.index')->with('success', 'Konsultasi berhasil disimpan');
}


    public function show($id)
    {
        $konsultasi = Konsultasi::with(['pasien', 'dokter'])->findOrFail($id);
        return view('pasien.konsultasi.show', compact('konsultasi'));
    }
    public function edit($id)
    {
        $konsultasi = Konsultasi::findOrFail($id);
    
        if ($konsultasi->id_pasien != session('pasien_id') && $konsultasi->id_dokter != session('dokter_id')) {
            return redirect()->route('pasien.konsultasi.index')->with('error', 'Anda tidak berhak mengedit konsultasi ini.');
        }
    
        $dokter = Dokter::all();
    
        return view('pasien.konsultasi.edit', compact('konsultasi', 'dokter'));
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_dokter' => 'required|exists:dokter,id',
            'subject' => 'required|string|max:30',
            'chat_note' => 'required|string|max:500',
        ]);
    
        $konsultasi = Konsultasi::findOrFail($id);
    
        if ($konsultasi->id_pasien != session('pasien_id') && $konsultasi->id_dokter != session('dokter_id')) {
            return redirect()->route('pasien.konsultasi.index')->with('error', 'Anda tidak berhak mengedit konsultasi ini.');
        }
    
        $konsultasi->update([
            'id_dokter' => $request->id_dokter,
            'subject' => $request->subject,
            'chat_note' => $request->chat_note,
        ]);
    
        return redirect()->route('pasien.konsultasi.index')->with('success', 'Konsultasi berhasil diperbarui');
    }
    
    public function destroy($id)
    {
        $konsultasi = Konsultasi::findOrFail($id);
    
        if ($konsultasi->id_pasien != session('pasien_id') && $konsultasi->id_dokter != session('dokter_id')) {
            return redirect()->route('pasien.konsultasi.index')->with('error', 'Anda tidak berhak menghapus konsultasi ini.');
        }
    
        $konsultasi->delete();
    
        return redirect()->route('pasien.konsultasi.index')->with('success', 'Konsultasi berhasil dihapus');
    }
    
}
