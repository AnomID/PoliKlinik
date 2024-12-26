<ul
    class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion"
    id="accordionSidebar"
>
    <!-- Sidebar - Brand -->
    <a
        class="sidebar-brand d-flex align-items-center justify-content-center"
        href="{{ route('admin.dashboard') }}"
    >
        <div class="sidebar-brand-icon">
            <img src="{{ asset('assets/logopng.png') }}" alt="Logo Udinus" style="height: 50px;">
        </div>
        <div class="sidebar-brand-text mx-3">PoliKlinik</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0" />
    <!-- Nav Item - Dashboard -->
    {{-- <li class="nav-item {{ Request::is('admin/dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>{{ session('nama') }}</span>
        </a>
    </li> --}}
    <li class="nav-item {{ Request::is('admin/dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider" />

    <!-- Heading -->
    <div class="sidebar-heading">
        Interface
    </div>

    <!-- Nav Item - Dokter Collapse Menu -->
    <li class="nav-item {{ Request::is('admin/dokter*') ? 'active' : '' }}">
        <a
            class="nav-link collapsed"
            href="#"
            data-toggle="collapse"
            data-target="#collapseDokter"
            aria-expanded="{{ Request::is('admin/dokter*') ? 'true' : 'false' }}"
            aria-controls="collapseDokter"
        >
            <i class="nav-icon fas fa-user-md"></i>
            <span>Daftar Poli</span>
        </a>
        <div
            id="collapseDokter"
            class="collapse {{ Request::is('admin/dokter*') ? 'show' : '' }}"
            aria-labelledby="headingDokter"
            data-parent="#accordionSidebar"
        >
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Manajemen Pasien:</h6>
                <a class="collapse-item {{ Request::is('admin/dokter') ? 'active' : '' }}" href="{{ route('pasien.daftar.create') }}">Ajukan Pendaftaran</a>
                <a class="collapse-item {{ Request::is('admin/dokter/create') ? 'active' : '' }}" href="{{ route('pasien.daftar.index') }}">History Pendaftaran</a>
            </div>
        </div>
    </li>


    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block" />

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
