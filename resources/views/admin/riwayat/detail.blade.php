@extends('layouts.app-dashboard')

@section('title', 'Detail Riwayat Periksa')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Riwayat Periksa: {{ $pasien->nama }}</h1>
    <a href="{{ route('admin.riwayat.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Pasien</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table">
                    <tr>
                        <th width="150">Nama</th>
                        <td>{{ $pasien->nama }}</td>
                    </tr>
                    <tr>
                        <th>No. RM</th>
                        <td>{{ $pasien->no_rm }}</td>
                    </tr>
                    <tr>
                        <th>No. KTP</th>
                        <td>{{ $pasien->no_ktp }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table">
                    <tr>
                        <th width="150">Alamat</th>
                        <td>{{ $pasien->alamat }}</td>
                    </tr>
                    <tr>
                        <th>No. Telepon</th>
                        <td>{{ $pasien->no_hp }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Riwayat Pemeriksaan</h6>
    </div>
    <div class="card-body">
        @foreach($riwayatPeriksa as $index => $periksa)
        <div class="card mb-3">
            <div class="card-header">
                <strong>Kunjungan #{{ count($riwayatPeriksa) - $index }}</strong> -
                {{ $periksa->tgl_periksa->format('d/m/Y H:i') }}
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th width="200">Dokter</th>
                            <td>{{ $periksa->daftarPoli->jadwalPeriksa->dokter->nama }}</td>
                        </tr>
                        <tr>
                            <th>Keluhan</th>
                            <td>{{ $periksa->daftarPoli->keluhan }}</td>
                        </tr>
                        <tr>
                            <th>Catatan</th>
                            <td>{{ $periksa->catatan }}</td>
                        </tr>
                        <tr>
                            <th>Obat</th>
                            <td>
                                <ul class="mb-0">
                                    @foreach($periksa->detailPeriksa as $detail)
                                        <li>{{ $detail->obat->nama_obat }}</li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <th>Biaya Periksa</th>
                            <td>Rp {{ number_format($periksa->biaya_periksa, 0, ',', '.') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
