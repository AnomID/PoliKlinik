@extends('layouts.app-dashboard')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Tambah Konsultasi</h1>

    <form action="{{ route('pasien.konsultasi.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="id_pasien">Pasien</label>
            <input type="text" class="form-control" value="{{ $pasien->nama }}" readonly>
        </div>

        <div class="form-group">
            <label for="id_dokter">Dokter</label>
            <select name="id_dokter" id="id_dokter" class="form-control" required>
                <option value="">Pilih Dokter</option>
                @foreach($dokter as $d)
                    <option value="{{ $d->id }}">{{ $d->nama }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="subject">Subject</label>
            <textarea name="subject" id="subject" rows="5" class="form-control" required>{{ old('subject') }}</textarea>
        </div>
        <div class="form-group">
            <label for="chat_note">Pertanyaan</label>
            <textarea name="chat_note" id="chat_note" rows="5" class="form-control" required>{{ old('chat_note') }}</textarea>
        </div>

        <!-- <div class="form-group">
            <label for="jawaban">Jawaban</label>
            <textarea name="jawaban" id="jawaban" rows="5" class="form-control" required>{{ old('jawaban') }}</textarea>
        </div> -->

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('pasien.konsultasi.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
@endsection
