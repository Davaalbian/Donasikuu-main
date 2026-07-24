<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        <div class="sidebar-brand-icon">
            <img src="{{ asset('assets/img/Logodonasi.png') }}" style="width:40px;height:40px;border-radius:5px;">
        </div>
        <div class="sidebar-brand-text mx-3">Donasiku</div>
    </a>

    <hr class="sidebar-divider my-0">

    <!-- Dashboard -->
    <li class="nav-item {{ Route::is('dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <div class="sidebar-heading">Manajemen Data</div>

    <!-- Data Donasi -->
    <li class="nav-item {{ Route::is('data_donasi.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('data_donasi.index') }}">
            <i class="fas fa-fw fa-table"></i>
            <span>Data Donasi</span>
        </a>
    </li>

    <!-- Data Pengguna -->
    <li class="nav-item {{ Route::is('data_pengguna.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('data_pengguna.index') }}">
            <i class="fas fa-fw fa-user-friends"></i>
            <span>Data Pengguna</span>
        </a>
    </li>

    <!-- Data Penerima -->
    <li class="nav-item {{ Route::is('data_penerima.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('data_penerima.index') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>Data Penerima</span>
        </a>
    </li>

    <!-- Data Penyaluran -->
    <li class="nav-item {{ Route::is('data_penyaluran.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('data_penyaluran.index') }}">
            <i class="fas fa-fw fa-truck"></i>
            <span>Data Penyaluran</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <div class="sidebar-heading">Laporan</div>

    <li class="nav-item {{ Route::is('laporan.donasi') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('laporan.donasi') }}">
            <i class="fas fa-fw fa-file-alt"></i>
            <span>Laporan Donasi</span>
        </a>
    </li>

    <li class="nav-item {{ Route::is('laporan.penyaluran') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('laporan.penyaluran') }}">
            <i class="fas fa-fw fa-truck"></i>
            <span>Laporan Penyaluran</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <!-- Logout -->
    <li class="nav-item">
        <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">
            <i class="fas fa-fw fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
    </li>

</ul>