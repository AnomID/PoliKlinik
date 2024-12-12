@extends('layouts.app')

@section('title', 'Dashboard Pasien')

@section('content')
    <div class="container py-5">
        <h3>Selamat datang, {{ session('pasien_nama') }}</h3>
        <p>Ini adalah halaman dashboard pasien.</p>
    </div>
@endsection
