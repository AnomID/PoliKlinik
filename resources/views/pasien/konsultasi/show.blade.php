@extends('layouts.app-dashboard')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Detail Konsultasi</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="mb-3">
                <strong>Pasien:</strong> {{ $konsultasi->pasien->name }}
            </div>

            <div class="mb-3">
                <strong>Dokter:</strong> {{ $konsultasi->dokter->name }}
            </div>

            <div class="mb-3">
                <strong>Catatan Chat:</strong>
                <p>{{ $konsultasi->chat_note }}</p>
            </div>

            <a href="{{ route('pasien.konsultasi.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
@endsection
