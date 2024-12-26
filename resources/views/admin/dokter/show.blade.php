<!-- resources/views/admin/dokter/show.blade.php -->
@extends('layouts.app-dashboard')

@section('title', 'Detail Dokter')

@section('content')
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail Dokter</h1>
    <a href="{{ route('admin.dokter.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
      <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
    </a>
  </div>

  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Informasi Dokter</h6>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-md-6">
          <h5><strong>Nama:</strong></h5>
          <p>{{ $dokter->nama }}</p>
        </div>
        <div class="col-md-6">
          <h5><strong>Poli:</strong></h5>
          <p>{{ $dokter->poli->nama_poli }}</p>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <h5><strong>Alamat:</strong></h5>
          <p>{{ $dokter->alamat }}</p>
        </div>
        <div class="col-md-6">
          <h5><strong>No. HP:</strong></h5>
          <p>{{ $dokter->no_hp }}</p>
        </div>
      </div>
    </div>
  </div>
@endsection
