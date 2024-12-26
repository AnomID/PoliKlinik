<!-- Example admin dashboard view -->
@extends('layouts.app-dashboard')

@section('content')
    {{-- <>Dashboard Dokter {{ Auth::user()->nama }}
    <!-- Admin-specific content goes here -->

    <!-- Logout Link --> --}}
    <a href="{{ route('logout.dokter') }}" class="btn btn-danger">Logout</a>
@endsection
