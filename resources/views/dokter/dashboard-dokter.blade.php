<!-- Example dokter dashboard view -->
@extends('layouts.app')

@section('content')
    <h1>Dashboard Dokter</h1>
    <!-- Dokter-specific content goes here -->

    <!-- Logout Link -->
    <a href="{{ route('logout.dokter') }}" class="btn btn-danger">Logout</a>
@endsection
