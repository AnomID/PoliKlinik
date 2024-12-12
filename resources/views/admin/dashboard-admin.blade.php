<!-- Example admin dashboard view -->
@extends('layouts.app-dashboard')

@section('content')
    <h1>Dashboard Admin</h1>
    <!-- Admin-specific content goes here -->

    <!-- Logout Link -->
    <a href="{{ route('logout.admin') }}" class="btn btn-danger">Logout</a>
@endsection
