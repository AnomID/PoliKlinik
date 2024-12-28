@extends('layouts.app-dashboard')

@section('title', 'Detail Pemeriksaan')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail Pemeriksaan</h1>
    <a href="{{ route('dokter.periksa.index') }}" class="btn btn-sm btn-secondary shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Pemeriksaan</h6>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-6">
                <table class="table">
                    <tr>
                        <th>Nama Pasien</th>
                        <td>{{ $periksa->daftarPoli->pasien->nama }}</td>
                    </tr>
                    <tr>
                        <th>No. RM</th>
                        <td>{{ $periksa->daftarPoli->pasien->no_rm }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Periksa</th>
                        <td>{{ $periksa->tgl_periksa->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Catatan</th>
                        <td>{{ $periksa->catatan }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Obat</th>
                        <th>Jumlah</th>
                        <th>Harga Satuan</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($periksa->detailPeriksa as $index => $detail)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $detail->obat->nama_obat }}</td>
                        <td>{{ $detail->jumlah }}</td>
                        <td>Rp {{ number_format($detail->obat->harga, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($detail->obat->harga * $detail->jumlah, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="4" class="text-right">Biaya Pemeriksaan</th>
                        <td>Rp 150.000</td>
                    </tr>
                    <tr>
                        <th colspan="4" class="text-right">Total Biaya</th>
                        <td>Rp {{ number_format($periksa->biaya_periksa, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection
