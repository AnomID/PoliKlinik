<!-- resources/views/admin/poli/create.blade.php -->
@extends('layouts.app-dashboard')

@section('title', 'Tambah Poli')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Poli</h1>
        <a href="{{ route('admin.poli.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Tambah Poli</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.poli.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="nama_poli">Nama Poli</label>
                    <input type="text" class="form-control @error('nama_poli') is-invalid @enderror" id="nama_poli" name="nama_poli" value="{{ old('nama_poli') }}" required>
                    @error('nama_poli')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="keterangan">Keterangan</label>
                    <textarea class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan" rows="3">{{ old('keterangan') }}</textarea>
                    @error('keterangan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.poli.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
@endsection
