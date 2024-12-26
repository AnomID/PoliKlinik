@extends('layouts.app-dashboard')

@section('title', 'Daftar Poli')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Daftar Poli</h1>
<a href="{{ route('pasien.daftar.create') }}" class="btn btn-primary mb-3">Daftar Poli Baru</a>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Dokter</th>
            <th>Hari</th>
            <th>Keluhan</th>
            <th>No Antrian</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($daftarPoli as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->jadwalPeriksa->dokter->nama }}</td>
                <td>{{ $item->jadwalPeriksa->hari }}</td>
                <td>{{ $item->keluhan }}</td>
                <td>{{ $item->no_antrian }}</td>
                <td>
                    <form action="{{ route('pasien.daftar.destroy', $item->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Batalkan</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
