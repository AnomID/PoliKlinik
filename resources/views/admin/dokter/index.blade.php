<!-- resources/views/admin/dokter/index.blade.php -->
@extends('layouts.app-dashboard')

@section('title', 'Daftar Dokter')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Daftar Dokter</h1>
        <div>
            <a href="{{ route('admin.dokter.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Dokter
            </a>
            {{-- <a href="{{ route('admin.dokter.export') }}" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm">
                <i class="fas fa-file-export fa-sm text-white-50"></i> Export Data
            </a> --}}
        </div>
    </div>

    <!-- Card untuk Daftar Dokter -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Obat</h6>
        </div>
        <div class="card-body">
            <!-- Form Pencarian -->
            <form method="GET" action="{{ route('admin.dokter.index') }}" class="form-inline mb-3">
                <div class="form-group mr-2">
                    <input type="text" name="search" class="form-control" placeholder="Cari dokter..." value="{{ request('search') }}">
                </div>
                <button type="submit" class="btn btn-outline-success">Cari</button>
                @if(request('search'))
                    <a href="{{ route('admin.dokter.index') }}" class="btn btn-outline-secondary ml-2">Reset</a>
                @endif
            </form>

            <!-- Tabel Daftar Dokter -->
            <div class="table-responsive">
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

                <!-- Tabel -->
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID Dokter</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Poli</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dokters as $dokter)
                            <tr>
                                <td>{{ $dokter->id }}</td>
                                <td>{{ $dokter->nama }}</td>
                                <td>{{ $dokter->alamat }}</td>
                                <td>{{ $dokter->poli->nama_poli }}</td>
                                <td>
                                    <a href="{{ route('admin.dokter.show', $dokter->id) }}" class="btn btn-info btn-sm">Lihat</a>
                                    <a href="{{ route('admin.dokter.edit', $dokter->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('admin.dokter.destroy', $dokter->id) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus dokter ini?');">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada data dokter ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Paginasi dengan Parameter Pencarian -->
                <div class="mt-3">
                    {{ $dokters->appends(['search' => request('search')])->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@endsection
