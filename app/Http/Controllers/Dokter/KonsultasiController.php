<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\Konsultasi;
use App\Models\Pasien;
use App\Models\Dokter;
use Illuminate\Http\Request;

class KonsultasiController extends Controller
{

    public function index()
    {
        $dokter = Dokter::find(session('dokter_id'));
    
        if (!$dokter) {
            
            return redirect()->route('login')->with('error', 'Pasien tidak ditemukan di session.');
        }
    
        $konsultasis = Konsultasi::where('id_dokter', $dokter->id)
                                 ->orWhere('id_pasien', session('pasien_id'))
                                 ->with(['pasien', 'dokter'])
                                 ->get();
    
        return view('dokter.konsultasi.index', compact('konsultasis', 'dokter'));

    }
    
    public function create()
{
    $dokter = Dokter::find(session('dokter_id'));

    // if (!$pasien) {
    //     return redirect()->route('login')->with('error', 'Pasien tidak ditemukan di session.');
    // }

    // $dokter = Dokter::all();

    return view('dokter.konsultasi.create', compact('pasien', 'dokter'));
}



public function store(Request $request)
{
    $request->validate([
        'id_pasien' => 'required|exists:pasien,id',
        'id_dokter' => 'required|exists:dokter,id',
        'subject' => 'required|string|max:30',
        'chat_note' => 'required|string|max:500',
        'jawaban' => 'required|string|max:500',
    ]);

    $pasien_id = session('pasien_id');
    
    if (!$pasien_id) {
        return redirect()->route('login')->with('error', 'Pasien tidak ditemukan di session.');
    }

    $dokter = Dokter::find($request->id_dokter);

    if (!$dokter) {
        return redirect()->route('dokter.konsultasi.create')->with('error', 'Dokter tidak valid.');
    }

    Konsultasi::create([
        'id_pasien' => $request->id_pasien,
        'id_dokter' => $request->id_dokter,
        'subject' => $request->subject,
        'chat_note' => $request->chat_note,
        'jawaban' => $request->jawaban,
    ]);

    return redirect()->route('dokter.konsultasi.index')->with('success', 'Konsultasi berhasil disimpan');
}


    public function show($id)
    {
        $konsultasi = Konsultasi::with(['pasien', 'dokter'])->findOrFail($id);
        return view('dokter.konsultasi.show', compact('konsultasi'));
    }
    public function edit($id)
    {
        $konsultasi = Konsultasi::findOrFail($id);
    
        if ($konsultasi->id_pasien != session('pasien_id') && $konsultasi->id_dokter != session('dokter_id')) {
            return redirect()->route('dokter.konsultasi.index')->with('error', 'Anda tidak berhak mengedit konsultasi ini.');
        }
    
        $dokter = Dokter::all();
    
        return view('dokter.konsultasi.edit', compact('konsultasi', 'dokter'));
    }
    

    public function update(Request $request, $id)
{
    $request->validate([
        // 'id_pasien' => 'required|exists:pasien,id',
        // 'id_dokter' => 'required|exists:dokter,id',
        // 'subject' => 'required|string|max:30',
        'jawaban' => 'required|string|max:500',
    ]);

    $konsultasi = Konsultasi::findOrFail($id);

    if ($konsultasi->id_pasien != session('pasien_id') && $konsultasi->id_dokter != session('dokter_id')) {
        return redirect()->route('dokter.konsultasi.index')->with('error', 'Anda tidak berhak mengedit konsultasi ini.');
    }

    $konsultasi->update([
        // 'id_dokter' => $request->id_dokter,
        // 'subject' => $request->subject,
        'jawaban' => $request->jawaban,
    ]);

    return redirect()->route('dokter.konsultasi.index')->with('success', 'Konsultasi berhasil diperbarui');
}

    public function destroy($id)
    {
        $konsultasi = Konsultasi::findOrFail($id);
    
        if ($konsultasi->id_pasien != session('pasien_id') && $konsultasi->id_dokter != session('dokter_id')) {
            return redirect()->route('dokter.konsultasi.index')->with('error', 'Anda tidak berhak menghapus konsultasi ini.');
        }
    
        $konsultasi->delete();
    
        return redirect()->route('dokter.konsultasi.index')->with('success', 'Konsultasi berhasil dihapus');
    }
    
}
