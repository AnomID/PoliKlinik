<!-- resources/views/admin/obat/index.blade.php -->
@extends('layouts.app-dashboard')

@section('title', 'Daftar Obat')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Daftar Obat</h1>
        <div>
            <a href="{{ route('admin.obat.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Obat
            </a>
            {{-- <a href="{{ route('admin.obat.export') }}" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm">
                <i class="fas fa-file-excel fa-sm text-white-50"></i> Export Excel
            </a> --}}
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Obat</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.obat.index') }}" class="form-inline mb-3">
                <input type="text" name="search" class="form-control mr-sm-2" placeholder="Cari Obat..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-outline-success my-2 my-sm-0">Cari</button>
                @if(request('search'))
                    <a href="{{ route('admin.obat.index') }}" class="btn btn-outline-secondary ml-2">Reset</a>
                @endif
            </form>

            <div class="table-responsive">
                @include('partials.notification')

                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Obat</th>
                            <th>Kemasan</th>
                            <th>Stok</th>
                            <th>Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($obats as $obat)
                            <tr>
                                <td>{{ $obat->id }}</td>
                                <td>{{ $obat->nama_obat }}</td>
                                <td>{{ $obat->kemasan }}</td>
                                <td>{{ $obat->stok }}</td>
                                <td>Rp {{ number_format($obat->harga, 2, ',', '.') }}</td>
                                <td>
                                    <a href="{{ route('admin.obat.show', $obat->id) }}" class="btn btn-info btn-sm" title="Lihat">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.obat.edit', $obat->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.obat.destroy', $obat->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus obat ini?');">
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
                                <td colspan="6" class="text-center">Tidak ada data obat.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-3">
                    {{ $obats->appends(['search' => request('search')])->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@endsection
