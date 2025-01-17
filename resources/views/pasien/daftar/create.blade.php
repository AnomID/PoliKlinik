@extends('layouts.app-dashboard')

@section('title', 'Pendaftaran Poli')

@section('content')
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Pendaftaran Poli</h1>
    <a href="{{ route('pasien.daftar.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
      <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
    </a>
  </div>

  @if(session('success'))
    <div class="alert alert-success">
      {{ session('success') }}
    </div>
  @endif

  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Form Pendaftaran Poli</h6>
    </div>
    <div class="card-body">
      <form action="{{ route('pasien.daftar.create') }}" method="GET">
        @csrf

        <!-- No. RM (Read-Only) -->
        <div class="form-group">
          <label for="no_rm">No. RM</label>
          <input type="text" class="form-control" id="no_rm" name="no_rm" value="{{ $pasien->no_rm }}" readonly>
        </div>

        <!-- Pilih Poli (Auto Submit Form) -->
        <div class="form-group">
            <label for="id_poli">Poli</label>
            <select class="form-control @error('id_poli') is-invalid @enderror" id="id_poli" name="id_poli" onchange="this.form.submit()" required>
                <option value="" disabled {{ old('id_poli') ? '' : 'selected' }}>Pilih Poli</option>
                @foreach($polis as $poli)
                  <option value="{{ $poli->id }}" {{ old('id_poli', request('id_poli')) == $poli->id ? 'selected' : '' }}>
                    {{ $poli->nama_poli }}
                  </option>
                @endforeach
            </select>
            @error('id_poli')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
      </form>

      <form action="{{ route('pasien.daftar.store') }}" method="POST">
        @csrf

        <!-- Pilih Jadwal Periksa -->
        <div class="form-group">
            <label for="id_jadwal">Jadwal Periksa</label>
            <select class="form-control @error('id_jadwal') is-invalid @enderror" id="id_jadwal" name="id_jadwal" required {{ $jadwals->isEmpty() ? 'disabled' : '' }}>
                <option value="" disabled selected>Pilih Jadwal Periksa</option>
                @foreach($jadwals as $jadwal)
                  <option value="{{ $jadwal->id }}" {{ old('id_jadwal') == $jadwal->id ? 'selected' : '' }}>
                    {{ $jadwal->hari }} - {{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }} - Dokter {{ $jadwal->dokter->nama }}
                  </option>
                @endforeach
            </select>
            @error('id_jadwal')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Keluhan -->
        <div class="form-group">
          <label for="keluhan">Keluhan</label>
          <textarea class="form-control @error('keluhan') is-invalid @enderror" id="keluhan" name="keluhan" rows="3" required>{{ old('keluhan') }}</textarea>
          @error('keluhan')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <!-- Tombol Submit -->
        <button type="submit" class="btn btn-primary" {{ $jadwals->isEmpty() ? 'disabled' : '' }}>Daftar</button>
        <a href="{{ route('pasien.daftar.index') }}" class="btn btn-secondary">Batal</a>
      </form>
    </div>
  </div>
@endsection
