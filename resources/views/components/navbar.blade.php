    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top" id="mainNav">
        <div class="container px-4">
            <a class="navbar-brand" href="{{ route('home') }}">Poli Klinik</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                Menu
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto">
                    <!-- Public Links -->
                    @if(!session('user_role') && !session('dokter_id') && !session('pasien_id'))
                        <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('dokter.loginForm') }}">Login Dokter</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('pasien.loginForm') }}">Login Pasien</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('pasien.registerForm') }}">Register Pasien</a></li>
                    @endif

                    <!-- Admin Links -->
                    @if(session('user_role') === 'admin')
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Admin Dashboard</a></li>
                        <!-- Add more admin-specific links here -->
                        <li class="nav-item"><a class="nav-link" href="{{ route('logout.admin') }}">Logout</a></li>
                    @endif

                    <!-- Dokter Links -->
                    @if(session('dokter_id'))
                        <li class="nav-item"><a class="nav-link" href="{{ route('dokter.dashboard') }}">Dokter Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('dokter.poli') }}">Poli</a></li>
                        <!-- Add more dokter-specific links here -->
                        <li class="nav-item"><a class="nav-link" href="{{ route('logout.dokter') }}">Logout</a></li>
                    @endif

                    <!-- Pasien Links -->
                    @if(session('pasien_id'))
                        <li class="nav-item"><a class="nav-link" href="{{ route('pasien.dashboard') }}">Pasien Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('pasien.daftar.periksa') }}">Daftar Periksa</a></li>
                        <!-- Add more pasien-specific links here -->
                        <li class="nav-item"><a class="nav-link" href="{{ route('logout.pasien') }}">Logout</a></li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
