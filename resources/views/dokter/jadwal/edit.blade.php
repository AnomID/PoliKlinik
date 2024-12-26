@extends('layouts.app-dashboard')

@section('title', 'Edit Jadwal Periksa')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Jadwal Periksa</h1>
        <a href="{{ route('dokter.jadwal.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Edit Jadwal Periksa</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('dokter.jadwal.update', $jadwalPeriksa->id) }}" method="POST">
                @csrf
@endsection
