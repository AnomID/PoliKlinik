@extends('layouts.app')

@section('title', 'Login Pasien')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <!-- Card Start -->
                <div class="card shadow-sm">
                    <div class="card-header text-center bg-primary text-white">
                        <h3 class="mb-0">Login Pasien</h3>
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

                        <!-- Login Form -->
                        <form method="POST" action="{{ route('pasien.login') }}">
                            @csrf  <!-- CSRF token for security -->

                            <!-- Nama Field -->
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text" id="nama-icon">
                                        <i class="bi bi-person"></i>
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
                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text" id="alamat-icon">
                                        <i class="bi bi-geo-alt"></i>
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

                            <!-- Remember Me Checkbox -->
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">Ingat Saya</label>
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Login</button>
                            </div>
                        </form>

                        <!-- Additional Links -->
                        <div class="mt-4 text-center">
                            <p>Belum punya akun? <a href="{{ route('pasien.registerForm') }}">Daftar di sini</a>.</p>
                            {{-- Optional: Add password reset link if implemented --}}
                            {{-- <p><a href="{{ route('password.request') }}">Lupa Password?</a></p> --}}
                        </div>
                    </div>
                </div>
                <!-- Card End -->
            </div>
        </div>
    </div>
@endsection
