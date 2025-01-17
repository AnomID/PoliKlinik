@extends('layouts.app-dashboard')

@section('title', 'Detail Pendaftaran Poli')

@section('content')
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail Pendaftaran Poli</h1>
    <a href="{{ route('pasien.daftar.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
      <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
    </a>
  </div>

  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Informasi Pendaftaran Poli</h6>
    </div>
    <div class="card-body">
      <table class="table table-bordered">
        <tr>
          <th>No. RM</th>
          <td>{{ $daftarPoli->no_rm ?? '-' }}</td>
        </tr>
        <tr>
          <th>Poli</th>
          <td>{{ $daftarPoli->nama_poli ?? 'Poli tidak ditemukan' }}</td>
        </tr>
        <tr>
          <th>Dokter</th>
          <td>{{ $daftarPoli->nama_dokter ?? '-' }}</td>
        </tr>
        <tr>
          <th>Jadwal Periksa</th>
          <td>{{ $daftarPoli->hari ?? '-' }} - {{ $daftarPoli->jam_mulai ?? '-' }} - {{ $daftarPoli->jam_selesai ?? '-' }}</td>
        </tr>
        <tr>
          <th>Keluhan</th>
          <td>{{ $daftarPoli->keluhan ?? '-' }}</td>
        </tr>
        <tr>
          <th>No. Antrian</th>
          <td>{{ $daftarPoli->no_antrian ?? '-' }}</td>
        </tr>
        <tr>
          <th>Tanggal Periksa</th>
          <td>{{ $daftarPoli->tgl_periksa ?? '-' }}</td>
        </tr>
        <tr>
          <th>Catatan</th>
          <td>{{ $daftarPoli->catatan ?? '-' }}</td>
        </tr>
        <tr>
          <th>Biaya Periksa</th>
          <td>Rp {{ number_format($daftarPoli->biaya_periksa ?? 0, 0, ',', '.') }}</td>
        </tr>
      </table>

      <a href="{{ route('pasien.daftar.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
  </div>
@endsection
