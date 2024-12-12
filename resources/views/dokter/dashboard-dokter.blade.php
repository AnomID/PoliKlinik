@extends('layouts.app')

@section('title', 'Dashboard Dokter')

@section('content')
    <div class="container py-5">
        <h3>Selamat datang, Dr. {{ session('dokter_nama') }}</h3>
        <p>Ini adalah halaman dashboard dokter.</p>
    </div>
@endsection
