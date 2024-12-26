@extends('layouts.app-dashboard')

@section('title', 'Detail Jadwal Periksa')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Jadwal Periksa</h1>
        <a href="{{ route('jadwal-periksa.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Informasi Jadwal Periksa</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5><strong>Dokter:</strong></h5>
                    <p>{{ $jadwalPeriksa->dokter->nama }}</p>
                </div>
                <div class="col-md-6">
                    <h5><strong>Poli:</strong></h5>
                    <p>{{ $jadwalPeriksa->dokter->poli->nama_poli }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <h5><strong>Hari:</strong></h5>
                    <p>{{ $jadwalPeriksa->hari }}</p>
                </div>
                <div class="col-md-6">
                    <h5><strong>Jam Mulai:</strong></h5>
                    <p>{{ \Carbon\Carbon::parse($jadwalPeriksa->jam_mulai)->format('H:i') }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <h5><strong>Jam Selesai:</strong></h5>
                    <p>{{ \Carbon\Carbon::parse($jadwalPeriksa->jam_selesai)->format('H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
