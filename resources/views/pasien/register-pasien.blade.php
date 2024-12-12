@extends('layouts.app') <!-- Changed to use the main app layout for consistency -->

@section('title', 'Register Pasien')

@section('content')
    <!-- Registration Form Section -->
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <!-- Card Start -->
                <div class="card shadow-sm">
                    <div class="card-header text-center bg-success text-white">
                        <h3 class="mb-0">Registrasi Pasien</h3>
                    </div>
                    <div class="card-body">
                        <!-- Success Message -->
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <!-- Error Messages -->
                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <!-- Registration Form -->
                        <form method="POST" action="{{ route('pasien.register.store') }}" novalidate>
                            @csrf  <!-- CSRF token for security -->

                            <!-- Nama Field -->
                            <div class="mb-4">
                                <label for="nama" class="form-label">Nama <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text" id="nama-icon">
                                        <i class="bi bi-person-fill"></i>
                                    </span>
                                    <input type="text"
                                           class="form-control @error('nama') is-invalid @enderror"
                                           id="nama"
                                           name="nama"
                                           value="{{ old('nama') }}"
                                           placeholder="Masukkan Nama Anda"
                                           required
                                           aria-describedby="nama-icon">
                                    @error('nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Alamat Field -->
                            <div class="mb-4">
                                <label for="alamat" class="form-label">Alamat <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text" id="alamat-icon">
                                        <i class="bi bi-geo-alt-fill"></i>
                                    </span>
                                    <input type="text"
                                           class="form-control @error('alamat') is-invalid @enderror"
                                           id="alamat"
                                           name="alamat"
                                           value="{{ old('alamat') }}"
                                           placeholder="Masukkan Alamat Anda"
                                           required
                                           aria-describedby="alamat-icon">
                                    @error('alamat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Nomor KTP Field -->
                            <div class="mb-4">
                                <label for="no_ktp" class="form-label">Nomor KTP <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text" id="no_ktp-icon">
                                        <i class="bi bi-credit-card-fill"></i>
                                    </span>
                                    <input type="text"
                                           class="form-control @error('no_ktp') is-invalid @enderror"
                                           id="no_ktp"
                                           name="no_ktp"
                                           value="{{ old('no_ktp') }}"
                                           placeholder="Masukkan Nomor KTP Anda"
                                           required
                                           aria-describedby="no_ktp-icon">
                                    @error('no_ktp')
                                        <div class="invalid-feedback">{{ 'Nomor KTP Sudah Terdaftar' }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Nomor Handphone Field -->
                            <div class="mb-4">
                                <label for="no_hp" class="form-label">Nomor Handphone <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text" id="no_hp-icon">
                                        <i class="bi bi-phone-fill"></i>
                                    </span>
                                    <input type="text"
                                           class="form-control @error('no_hp') is-invalid @enderror"
                                           id="no_hp"
                                           name="no_hp"
                                           value="{{ old('no_hp') }}"
                                           placeholder="Masukkan Nomor Handphone Anda"
                                           required
                                           aria-describedby="no_hp-icon">
                                    @error('no_hp')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid">
                                <button type="submit" class="btn btn-success">Daftar</button>
                            </div>
                        </form>

                        <!-- Additional Links -->
                        <div class="mt-4 text-center">
                            <p>Sudah punya akun? <a href="{{ route('pasien.loginForm') }}">Login di sini</a>.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
