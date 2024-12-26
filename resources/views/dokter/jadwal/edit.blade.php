@extends('layouts.app-dashboard')

@section('title', 'Edit Jadwal Periksa')

@section('content')
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Jadwal Periksa</h1>
    <a href="{{ route('dokter.jadwal.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
      <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
    </a>
  </div>

  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Form Edit Jadwal Periksa</h6>
    </div>
    <div class="card-body">
      <form action="{{ route('dokter.jadwal.update', $jadwal->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
          <label for="dokter_name">Nama Dokter</label>
          <input type="text" class="form-control" id="dokter_name" name="dokter_name" value="{{ $dokter->nama }}" readonly>
        </div>

        <div class="form-group">
          <label for="hari">Hari</label>
          <select class="form-control @error('hari') is-invalid @enderror" id="hari" name="hari" required>
            <option value="Senin" {{ old('hari', $jadwal->hari) == 'Senin' ? 'selected' : '' }}>Senin</option>
            <option value="Selasa" {{ old('hari', $jadwal->hari) == 'Selasa' ? 'selected' : '' }}>Selasa</option>
            <option value="Rabu" {{ old('hari', $jadwal->hari) == 'Rabu' ? 'selected' : '' }}>Rabu</option>
            <option value="Kamis" {{ old('hari', $jadwal->hari) == 'Kamis' ? 'selected' : '' }}>Kamis</option>
            <option value="Jumat" {{ old('hari', $jadwal->hari) == 'Jumat' ? 'selected' : '' }}>Jumat</option>
            <option value="Sabtu" {{ old('hari', $jadwal->hari) == 'Sabtu' ? 'selected' : '' }}>Sabtu</option>
            <option value="Minggu" {{ old('hari', $jadwal->hari) == 'Minggu' ? 'selected' : '' }}>Minggu</option>
          </select>
          @error('hari')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="form-group">
          <label for="jam_mulai">Jam Mulai</label>
          <input type="time" class="form-control @error('jam_mulai') is-invalid @enderror" id="jam_mulai" name="jam_mulai" value="{{ old('jam_mulai', $jadwal->jam_mulai) }}" required>
          @error('jam_mulai')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="form-group">
          <label for="jam_selesai">Jam Selesai</label>
          <input type="time" class="form-control @error('jam_selesai') is-invalid @enderror" id="jam_selesai" name="jam_selesai" value="{{ old('jam_selesai', $jadwal->jam_selesai) }}" required>
          @error('jam_selesai')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <button type="submit" class="btn btn-primary">Perbarui</button>
        <a href="{{ route('dokter.jadwal.index') }}" class="btn btn-secondary">Batal</a>
      </form>
    </div>
  </div>
@endsection
