@extends('layouts.app-dashboard')

@section('title', 'Daftar Pasien')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Daftar Pasien</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Pasien</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No Antrian</th>
                        <th>Nama Pasien</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($daftarPoli as $daftar)
                    <tr>
                        <td>{{ $daftar->no_antrian }}</td>
                        <td>{{ $daftar->pasien->nama }}</td>
                        <td>
                            @if($daftar->periksa)
                                <span class="badge badge-success">Sudah Diperiksa</span>
                            @else
                                <span class="badge badge-warning">Belum Diperiksa</span>
                            @endif
                        </td>
                        <td>
                            @if(!$daftar->periksa)
                                <a href="{{ route('dokter.periksa.create', $daftar->id) }}"
                                   class="btn btn-primary btn-sm">
                                    Periksa
                                </a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
