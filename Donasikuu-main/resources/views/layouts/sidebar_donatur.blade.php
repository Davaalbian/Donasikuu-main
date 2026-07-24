{{-- resources/views/layouts/sidebar_donatur.blade.php --}}

<ul class="navbar-nav bg-gradient-success sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('donatur.dashboard') }}">
        <div class="sidebar-brand-icon">
            <img src="{{ asset('assets/img/Logodonasi.png') }}" alt="Logo"
                style="width:40px; height:40px; object-fit:cover; border-radius:5px;">
        </div>
        <div class="sidebar-brand-text mx-3">Donasiku</div>
    </a>

    <hr class="sidebar-divider my-0">

    <!-- Dashboard -->
    <li class="nav-item {{ Route::is('donatur.dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('donatur.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <div class="sidebar-heading">Donasi Saya</div>

    <!-- Buat Donasi Baru -->
    <li class="nav-item {{ Route::is('donatur.donasi.create') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('donatur.donasi.create') }}">
            <i class="fas fa-fw fa-plus-circle"></i>
            <span>Mulai donasi</span>
        </a>
    </li>

    <!-- Donasi Saya -->
    <li class="nav-item {{ Route::is('donatur.riwayat_donasi') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('donatur.riwayat_donasi') }}">
            <i class="fas fa-fw fa-hand-holding-heart"></i>
            <span>Riwayat Donasi</span>
        </a>
    </li>

    <!-- Penyaluran (hanya lihat) -->
    <li class="nav-item {{ Route::is('donatur.penyaluran') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('donatur.penyaluran') }}">
            <i class="fas fa-fw fa-truck"></i>
            <span>Penyaluran Barang</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <div class="sidebar-heading">Akun</div>

    <!-- Profil -->
    <li class="nav-item {{ Route::is('donatur.profil') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('donatur.profil') }}">
            <i class="fas fa-fw fa-user-circle"></i>
            <span>Profil Saya</span>
        </a>
    </li>

    <!-- Logout -->
    <li class="nav-item">
        <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">
            <i class="fas fa-fw fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
    </li>

    <hr class="sidebar-divider d-none d-md-block">

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>