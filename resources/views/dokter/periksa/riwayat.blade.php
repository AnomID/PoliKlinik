@extends('layouts.app-dashboard')

@section('title', 'Riwayat Pemeriksaan')

@section('content')
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Riwayat Pemeriksaan Pasien</h6>
    </div>
    <div class="card-body">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>No</th>
            <th>Tanggal Pemeriksaan</th>
            <th>Catatan</th>
            <th>Biaya Pemeriksaan</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($periksaRecords as $periksa)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $periksa->tgl_periksa->format('d-m-Y') }}</td>
              <td>{{ $periksa->catatan }}</td>
              <td>Rp {{ number_format($periksa->biaya_periksa, 0, ',', '.') }}</td>
              <td>
                <a href="{{ route('dokter.periksa.detail', $periksa->id) }}" class="btn btn-info">Detail</a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endsection
