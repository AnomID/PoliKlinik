@extends('layouts.app-dashboard')

@section('title', 'Daftar Pendaftaran Poli')

@section('content')
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Daftar Pendaftaran Poli</h1>
    <a href="{{ route('pasien.daftar.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
      <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Pendaftaran
    </a>
  </div>

  @if(session('success'))
    <div class="alert alert-success">
      {{ session('success') }}
    </div>
  @endif

  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Daftar Pendaftaran Poli</h6>
    </div>
    <div class="card-body">
      @if($daftarPoli->isEmpty())
        <p>Tidak ada pendaftaran poli.</p>
      @else
        <div class="table-responsive">
          <table class="table table-bordered" id="daftarPoliTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>No.</th>
                <th>No. RM</th>
                <th>Poli</th>
                <th>Jadwal Periksa</th>
                <th>Keluhan</th>
                <th>No. Antrian</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach($daftarPoli as $index => $daftar)
                <tr>
                  <td>{{ $index + 1 }}</td>
                  <td>{{ $daftar->pasien->no_rm }}</td>
                  <td>{{ $daftar->jadwalPeriksa->dokter->poli->nama_poli }}</td>
                  <td>{{ $daftar->jadwalPeriksa->hari }} - {{ $daftar->jadwalPeriksa->jam_mulai }} - {{ $daftar->jadwalPeriksa->jam_selesai }}</td>
                  <td>{{ $daftar->keluhan }}</td>
                  <td>{{ $daftar->no_antrian }}</td>
                  <td>
                    <a href="{{ route('pasien.daftar.show', $daftar->id) }}" class="btn btn-info btn-sm">Lihat</a>
                    <a href="{{ route('pasien.daftar.edit', $daftar->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('pasien.daftar.destroy', $daftar->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pendaftaran ini?');">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @endif
    </div>
  </div>
@endsection
