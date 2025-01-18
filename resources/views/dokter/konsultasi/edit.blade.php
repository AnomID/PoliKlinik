@extends('layouts.app-dashboard')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Jawaban Konsultasi</h1>

    <form action="{{ route('dokter.konsultasi.update', $konsultasi->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <!-- <div class="form-group">
            <label for="id_pasien">Pasien</label>
            <input type="text" class="form-control" value="{{ $konsultasi->pasien->nama }}" readonly>
        </div>

        <div class="form-group">
            <label for="id_dokter">Dokter</label>
            <input type="text" class="form-control" value="{{ $konsultasi->dokter->nama }}" readonly>
        </div>


        <div class="form-group">
            <label for="chat_note">Subject</label>
            <readonly name="chat_note" id="chat_note" rows="5" class="form-control" required>{{ old('subject', $konsultasi->subject) }}</readonly>
        </div>
        <div class="form-group">
            <label for="chat_note">Pertanyaan</label>
            <readonly name="chat_note" id="chat_note" rows="5" class="form-control" required>{{ old('chat_note', $konsultasi->chat_note) }}</readonly>
        </div>
 -->

        <!-- <div class="form-group">
            <label for="jawaban">Jawaban</label>
            <textarea name="jawaban" id="jawaban" rows="5" class="form-control" required>{{ old('jawaban') }}</textarea>
        </div> -->

        <div class="form-group">
            <label for="jawaban">Jawaban</label>
            <textarea name="jawaban" id="jawaban" rows="5" class="form-control" required>{{ old('jawaban', $konsultasi->jawaban) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('dokter.konsultasi.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
@endsection
