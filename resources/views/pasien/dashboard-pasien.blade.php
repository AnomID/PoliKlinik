<!-- Example pasien dashboard view -->
@extends('layouts.app-dashboard')

@section('content')
    <h1>Dashboard Pasien</h1>
    <!-- Pasien-specific content goes here -->

    <!-- Logout Link -->
    <a href="{{ route('logout.pasien') }}" class="btn btn-danger">Logout</a>
@endsection
