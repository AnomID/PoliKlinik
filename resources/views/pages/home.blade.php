@extends('layouts.app')

@section('title', 'Home - Sistem Temu Janji Pasien')
@section('content')
    <!-- Hero Section -->
    <section id="hero" class="vh-100 d-flex align-items-center" style="background: url('{{ asset('assets/klinikUdinus.jpg') }}') no-repeat center center/cover;">
        <div class="container text-center text-black">
            <h1 class="display-4 fw-bold">Selamat Datang di Sistem Pendaftaran Pasien dan Dokter</h1>
            <p class="lead mb-4">Mudah, Cepat, dan Terpercaya untuk Pendaftaran dan Pelayanan Kesehatan Anda</p>
            <a href="#login" class="btn btn-lg btn-primary">Mulai Sekarang</a>
        </div>
    </section>

    <!-- Login Section -->
    <section id="login" class="py-6 bg-light">
        <div class="container">
            <div class="row justify-content-center">
                @include('partials.cardLogin', [
                    'iconPath' => 'assets/patient.svg',
                    'title' => 'Registrasi Sebagai Pasien',
                    'description' => 'Apabila Anda adalah seorang Pasien, silahkan Registrasi terlebih dahulu untuk melakukan pendaftaran sebagai Pasien!',
                    'link' => route('pasien.registerForm'),
                    'linkText' => 'Register Pasien'
                ])
                @include('partials.cardLogin', [
                    'iconPath'=> 'assets/doctor.svg',
                    'title' => 'Login Sebagai Dokter',
                    'description' => 'Apabila Anda adalah seorang Dokter, silahkan Login terlebih dahulu untuk memulai melayani Pasien!',
                    'link' => route('dokter.loginForm'),
                    'linkText' => 'Login Dokter'
                ])
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-6">
        <div class="container px-4">
            <div class="row gx-4 justify-content-center">
                <div class="col-lg-10">
                    <h2 class="mb-4 text-center">Tentang Kami</h2>
                    <p class="lead text-center mb-5">Kami menyediakan sistem pendaftaran dan pelayanan kesehatan yang efisien dan mudah diakses oleh pasien dan dokter.</p>
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="d-flex align-items-start">
                                <i class="bi bi-gear-fill fs-3 text-primary me-3"></i>
                                <div>
                                    <h5>Fitur Lengkap</h5>
                                    <p>Menawarkan berbagai fitur yang memudahkan proses pendaftaran dan manajemen pasien serta dokter.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="d-flex align-items-start">
                                <i class="bi bi-speedometer2 fs-3 text-primary me-3"></i>
                                <div>
                                    <h5>Kecepatan</h5>
                                    <p>Proses pendaftaran dan login yang cepat, memungkinkan pengguna untuk segera mendapatkan akses.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="d-flex align-items-start">
                                <i class="bi bi-shield-lock-fill fs-3 text-primary me-3"></i>
                                <div>
                                    <h5>Keamanan</h5>
                                    <p>Sistem kami dilengkapi dengan fitur keamanan yang memastikan data pengguna terlindungi dengan baik.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="d-flex align-items-start">
                                <i class="bi bi-chat-dots-fill fs-3 text-primary me-3"></i>
                                <div>
                                    <h5>Dukungan Pelanggan</h5>
                                    <p>Kami menyediakan layanan dukungan pelanggan 24/7 untuk membantu Anda dengan segala pertanyaan atau masalah.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
     </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="py-6 bg-light">
        <div class="container">
            <h2 class="mb-4 text-center">Testimoni</h2>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <div class="text-center">
                                    <img src="{{ asset('assets/user1.jpeg') }}" class="rounded-circle mb-3" alt="User 1" width="100" height="100">
                                    <h5>Anom Innadanuansyah</h5>
                                    <p class="fst-italic">"Sistem pendaftaran ini sangat memudahkan saya sebagai pasien. Prosesnya cepat dan mudah."</p>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="text-center">
                                    <img src="{{ asset('assets/user3.jpeg') }}" class="rounded-circle mb-3" alt="User 2" width="100" height="100">
                                    <h5>Arkananta Abid</h5>
                                    <p class="fst-italic">"Sebagai dokter, saya merasa sistem ini membantu dalam mengelola pasien dengan lebih efisien."</p>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="text-center">
                                    <img src="{{ asset('assets/user2.jpeg') }}" class="rounded-circle mb-3" alt="User 3" width="100" height="100">
                                    <h5>Kezia Dyah</h5>
                                    <p class="fst-italic">"Aplikasi ini sangat membantu untuk memudahkan proses pendaftaran pasien dan dokter!"</p>
                                </div>
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action Section -->
    <section id="cta" class="py-6">
        <div class="container text-center">
            <h2 class="mb-4">Mulai Pendaftaran Anda Sekarang!</h2>
            <p class="lead mb-4">Daftarkan diri Anda sebagai pasien atau dokter dan nikmati kemudahan dalam mengelola kesehatan Anda.</p>
            <a href="#login" class="btn btn-lg btn-primary">Daftar Sekarang</a>
        </div>
    </section>
@endsection
