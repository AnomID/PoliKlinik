<!-- resources/views/admin/obat/show.blade.php -->
@extends('layouts.app-dashboard')

@section('title', 'Detail Obat')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Obat</h1>
        <a href="{{ route('admin.obat.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Informasi Obat</h6>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <h5><strong>ID Obat:</strong></h5>
                    <p>{{ $obat->id }}</p>
                </div>
                <div class="col-md-6">
                    <h5><strong>Nama Obat:</strong></h5>
                    <p>{{ $obat->nama_obat }}</p>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <h5><strong>Kemasan:</strong></h5>
                    <p>{{ $obat->kemasan }}</p>
                </div>
                <div class="col-md-6">
                    <h5><strong>Harga:</strong></h5>
                    <p>Rp {{ number_format($obat->harga, 2, ',', '.') }}</p>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <h5><strong>Stok:</strong></h5>
                    <p>{{ $obat->stok }}</p>
                </div>
                <div class="col-md-6">
                    <h5><strong>Total Nilai Stok:</strong></h5>
                    <p>Rp {{ number_format($obat->stok * $obat->harga, 2, ',', '.') }}</p>
                </div>
            </div>
            <!-- Jika ada relasi lain, tambahkan di sini -->
        </div>
    </div>
@endsection
