@extends('layouts.app-dashboard')

@section('title', 'Tambah Daftar Poli')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tambah Daftar Poli</h1>
    <a href="{{ route('pasien.daftar.index') }}" class="btn btn-secondary">Kembali</a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Form Daftar Poli</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('pasien.daftar.store') }}" method="POST">
            @csrf

            <input type="hidden" name="id_pasien" value="{{ $pasienId }}">

            <div class="form-group">
                <label for="id_jadwal">Jadwal Dokter</label>
                <select class="form-control @error('id_jadwal') is-invalid @enderror" id="id_jadwal" name="id_jadwal" required>
                    <option value="" disabled selected>Pilih Jadwal</option>
                    @foreach($jadwalPeriksa as $jadwal)
                        <option value="{{ $jadwal->id }}" {{ old('id_jadwal') == $jadwal->id ? 'selected' : '' }}>
                            {{ $jadwal->dokter->nama }} - {{ $jadwal->hari }} ({{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }})
                        </option>
                    @endforeach
                </select>
                @error('id_jadwal')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="keluhan">Keluhan</label>
                <textarea class="form-control @error('keluhan') is-invalid @enderror" id="keluhan" name="keluhan" rows="3" required>{{ old('keluhan') }}</textarea>
                @error('keluhan')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('pasien.daftar.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection
