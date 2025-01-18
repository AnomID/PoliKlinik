@extends('layouts.app-dashboard')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Daftar Konsultasi</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('pasien.konsultasi.create') }}" class="btn btn-primary mb-3">Tambah Konsultasi</a>

    <div class="card shadow mb-4">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pasien</th>
                        <th>Nama Dokter</th>
                        <th>Subject</th>
                        <th>Pertanyaan</th>
                        <th>Jawaban</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($konsultasis as $konsultasi)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $konsultasi->pasien->nama}}</td>
                            <td>{{ $konsultasi->dokter->nama }}</td>
                            <td>{{ $konsultasi->subject }}</td>
                            <td>{{ $konsultasi->chat_note }}</td>
                            <td>{{ $konsultasi->jawaban }}</td>
                            <td>{{ $konsultasi->created_at->format('d M Y') }}</td>
                            <td>
                                <!-- <a href="{{ route('pasien.konsultasi.show', $konsultasi->id) }}" class="btn btn-info btn-sm">Detail</a> -->
                                <a href="{{ route('pasien.konsultasi.edit', $konsultasi->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('pasien.konsultasi.destroy', $konsultasi->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
