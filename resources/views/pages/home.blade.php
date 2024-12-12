@extends('layouts.app')

@section('title', 'Home - Scrolling Nav')  <!-- Menentukan judul halaman -->
@section('content')
@include('components.navbar')
  <!-- Menyertakan bagian header -->
    @include('partials.header')
    {{-- Login Section --}}

    <section id="login" class="py-6">
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
    <!-- About section-->
    <section id="about">
        <div class="container px-4">
            <div class="row gx-4 justify-content-center">
                <div class="col-lg-10">
                    <h2>About this page</h2>
                    <p class="lead">This is a great place to talk about your webpage. This template is purposefully unstyled so you can use it as a boilerplate or starting point for your own landing page designs! This template features:</p>
                    <ul>
                        <li>Clickable nav links that smooth scroll to page sections</li>
                        <li>Responsive behavior when clicking nav links perfect for a one page website</li>
                        <li>Bootstrap's scrollspy feature which highlights which section of the page you're on in the navbar</li>
                        <li>Minimal custom CSS so you are free to explore your own unique design options</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    @include('components.footer')
@endsection
