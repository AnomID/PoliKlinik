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
        <p>Anda belum memiliki pendaftaran poli.</p>
      @else
        <div class="table-responsive">
          <table class="table table-bordered" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>No.</th>
                <th>No RM</th>
                <th>Poli</th>
                <th>Dokter</th>
                <th>Hari</th>
                <th>Jam</th>
                <th>No Antrian</th>
                <th>Keluhan</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach($daftarPoli as $index => $daftar)
                <tr>
                  <td>{{ $index + 1 }}</td>
                  <td>{{ $daftar->no_rm ?? '-' }}</td>
                  <td>{{ $daftar->nama_poli ?? 'Poli dihapus' }}</td>
                  <td>{{ $daftar->nama_dokter ?? 'Dokter dihapus' }}</td>
                  <td>{{ $daftar->hari ?? '-' }}</td>
                  <td>{{ $daftar->jam_mulai ?? '-' }} - {{ $daftar->jam_selesai ?? '-' }}</td>
                  <td>{{ $daftar->no_antrian ?? '-' }}</td>
                  <td>{{ $daftar->keluhan ?? '-' }}</td>
                  <td>
                    <a href="{{ route('pasien.daftar.show', $daftar->daftar_poli_id) }}" class="btn btn-info btn-sm">Detail</a>
                    <a href="{{ route('pasien.daftar.edit', $daftar->daftar_poli_id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('pasien.daftar.destroy', $daftar->daftar_poli_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pendaftaran ini?');">
                      @csrf
                      @method('DELETE')
                      <button class="btn btn-danger btn-sm">Hapus</button>
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
