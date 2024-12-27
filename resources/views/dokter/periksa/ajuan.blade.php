<!-- resources/views/dokter/periksa/ajuan.blade.php -->
@extends('layouts.app-dashboard')

@section('title', 'Ajuan Periksa')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Ajuan Periksa Pasien</h1>
        <div>
            <a href="{{ route('dokter.periksa.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali ke Daftar Periksa
            </a>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Ajuan Periksa Pasien</h6>
        </div>
        <div class="card-body">
            <!-- Notifikasi -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <!-- Form untuk memilih tanggal -->
            <form method="GET" action="{{ route('dokter.periksa.ajuan') }}">
                <div class="form-row">
                    <div class="col-md-4">
                        <label for="tanggal">Pilih Tanggal</label>
                        <input type="date" id="tanggal" name="tanggal" class="form-control" value="{{ request('tanggal', \Carbon\Carbon::today()->toDateString()) }}">
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary mt-4">Filter</button>
                    </div>
                </div>
            </form>

            <div class="table-responsive mt-3">
                <table class="table table-bordered" id="dataTableAjuan" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No Antrian</th>
                            <th>Nama Pasien</th>
                            <th>Poli</th>
                            <th>Waktu Ajuan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ajuanPeriksa as $index => $item)
                            <tr>
                                <td>{{ $item->no_antrian }}</td>
                                <td>{{ $item->pasien->nama }}</td>
                                <td>{{ $item->jadwalPeriksa->dokter->poli->nama_poli }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('dokter.periksa.create', ['id_daftar_poli' => $item->id]) }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-stethoscope fa-sm text-white-50"></i> Periksa
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada ajuan periksa ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- Paginasi -->
            <div class="mt-3">
                {{ $ajuanPeriksa->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
@endsection
