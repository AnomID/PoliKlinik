<!-- resources/views/admin/poli/show.blade.php -->
@extends('layouts.app-dashboard')

@section('title', 'Detail Poli')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Poli</h1>
        <a href="{{ route('admin.poli.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Informasi Poli</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5><strong>ID Poli:</strong></h5>
                    <p>{{ $poli->id }}</p>
                </div>
                <div class="col-md-6">
                    <h5><strong>Nama Poli:</strong></h5>
                    <p>{{ $poli->nama_poli }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h5><strong>Keterangan:</strong></h5>
                    <p>{{ $poli->keterangan }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
