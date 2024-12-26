<!-- resources/views/admin/pasien/index.blade.php -->
@extends('layouts.app-dashboard')

@section('title', 'Daftar Pasien')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Daftar Pasien</h1>
        <a href="{{ route('admin.pasien.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Pasien
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Pasien</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.pasien.index') }}" class="form-inline mb-3">
                <input type="text" name="search" class="form-control mr-sm-2" placeholder="Cari Pasien..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-outline-success my-2 my-sm-0">Cari</button>
                @if(request('search'))
                    <a href="{{ route('admin.pasien.index') }}" class="btn btn-outline-secondary ml-2">Reset</a>
                @endif
            </form>

            <div class="table-responsive">
                @include('partials.notification')

                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>No. KTP</th>
                            <th>No. HP</th>
                            <th>No. RM</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($polisens as $pasien)
                            <tr>
                                <td>{{ $pasien->id }}</td>
                                <td>{{ $pasien->nama }}</td>
                                <td>{{ $pasien->alamat }}</td>
                                <td>{{ $pasien->no_ktp }}</td>
                                <td>{{ $pasien->no_hp }}</td>
                                <td>{{ $pasien->no_rm }}</td>
                                <td>
                                    <a href="{{ route('admin.pasien.show', $pasien->id) }}" class="btn btn-info btn-sm" title="Lihat">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.pasien.edit', $pasien->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.pasien.destroy', $pasien->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pasien ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data pasien.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-3">
                    {{ $polisens->appends(['search' => request('search')])->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@endsection
