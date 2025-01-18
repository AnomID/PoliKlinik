@extends('layouts.app-dashboard')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Edit Konsultasi</h1>

    <form action="{{ route('pasien.konsultasi.update', $konsultasi->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="id_pasien">Pasien</label>
            <input type="text" class="form-control" value="{{ $konsultasi->pasien->nama }}" readonly>
        </div>

        <div class="form-group">
            <label for="id_dokter">Dokter</label>
            <select name="id_dokter" id="id_dokter" class="form-control" required>
                <option value="">Pilih Dokter</option>
                @foreach($dokter as $d)
                    <option value="{{ $d->id }}" {{ $konsultasi->id_dokter == $d->id ? 'selected' : '' }}>{{ $d->nama }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="subject">Subject</label>
            <textarea name="subject" id="subject" rows="5" class="form-control" required>{{ old('subject', $konsultasi->subject) }}</textarea>
        </div>
        <div class="form-group">
            <label for="chat_note">Pertanyaan</label>
            <textarea name="chat_note" id="chat_note" rows="5" class="form-control" required>{{ old('chat_note', $konsultasi->chat_note) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('pasien.konsultasi.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
@endsection
