
@extends('layouts.app-dashboard')
@section('title', 'Tambah Jadwal Periksa')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tambah Jadwal Periksa</h1>
    <a href="{{ route('dokter.jadwal.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Tambah Jadwal Periksa</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('dokter.jadwal.store') }}" method="POST">
                @csrf
            <div class="form-group">
                <label for="dokter_name">Nama Dokter</label>
                <input type="text" class="form-control" id="dokter_name" name="dokter_name" value="{{ $dokter->nama }}" readonly>
                <input type="hidden" name="id_dokter" value="{{ $dokter->id }}">
            </div>
                <div class="form-group">
                    <label for="hari">Hari</label>
                    <select class="form-control" id="hari" name="hari" required>
                        <option value="Senin">Senin</option>
                        <option value="Selasa">Selasa</option>
                        <option value="Rabu">Rabu</option>
                        <option value="Kamis">Kamis</option>
                        <option value="Jumat">Jumat</option>
                        <option value="Sabtu">Sabtu</option>
                        <option value="Minggu">Minggu</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="jam_mulai">Jam Mulai</label>
                    <input type="time" class="form-control" id="jam_mulai" name="jam_mulai" required>
                </div>
                <div class="form-group">
                    <label for="jam_selesai">Jam Selesai</label>
                    <input type="time" class="form-control" id="jam_selesai" name="jam_selesai" required>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('dokter.jadwal.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
@endsection
