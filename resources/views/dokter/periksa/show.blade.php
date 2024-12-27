@extends('layouts.app-dashboard')

@section('content')
<div class="container">
    <h1>Detail Periksa</h1>

    <div class="card mb-4">
        <div class="card-header">
            Informasi Pasien
        </div>
        <div class="card-body">
            <p><strong>No RM:</strong> {{ $periksa->daftarPoli->pasien->no_rm }}</p>
            <p><strong>Nama:</strong> {{ $periksa->daftarPoli->pasien->nama }}</p>
            <p><strong>Tanggal Periksa:</strong> {{ $periksa->tgl_periksa->format('d-m-Y H:i') }}</p>
            <p><strong>Catatan:</strong> {{ $periksa->catatan }}</p>
            <p><strong>Biaya Periksa:</strong> Rp {{ number_format($periksa->biaya_periksa, 0, ',', '.') }}</p>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            Detail Obat
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Obat</th>
                        <th>Kemasan</th>
                        <th>Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($periksa->detailPeriksa as $index => $detail)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $detail->obat->nama_obat }}</td>
                            <td>{{ $detail->obat->kemasan }}</td>
                            <td>Rp {{ number_format($detail->obat->harga, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
