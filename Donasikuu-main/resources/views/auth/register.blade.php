@extends('layouts.auth')

@section('title', 'Register - Donasiku')

@section('content')
<div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-5">

        <!-- Logo + Judul -->
        <div class="text-center mb-4">
            <img src="{{ asset('assets/img/Logodonasi.png') }}" alt="Logo" class="mb-2" style="width:60px; height:60px;">
            <h1 class="h4 text-gray-900 font-weight-bold">Buat Akun Baru</h1>
            <p class="text-gray-600 small">Daftar sekarang untuk mengakses dashboard Donasiku</p>
        </div>

        <!-- Form Register -->
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Nama -->
            <div class="form-group">
                <input type="text" name="name" 
                    class="form-control form-control-user @error('name') is-invalid @enderror"
                    placeholder="Nama Lengkap" value="{{ old('name') }}" required>
                @error('name')
                    <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>

            <!-- Email -->
            <div class="form-group">
                <input type="email" name="email"
                    class="form-control form-control-user @error('email') is-invalid @enderror"
                    placeholder="Email" value="{{ old('email') }}" required>
                @error('email')
                    <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password -->
            <div class="form-group">

                <div class="position-relative">
                    <input type="password" name="password" id="password"
                        class="form-control form-control-user @error('password') is-invalid @enderror"
                        placeholder="Password" required>

                    <span toggle="#password" class="toggle-password"
                        style="position:absolute; right:15px; top:50%; transform:translateY(-50%); cursor:pointer;">
                        
                        <!-- ICON MATA (DEFAULT) -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="#4e73df" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M1.5 12s4.5-7.5 10.5-7.5S22.5 12 22.5 12 18 19.5 12 19.5 1.5 12 1.5 12z" />
                            <circle cx="12" cy="12" r="3" />
                        </svg>

                    </span>
                </div>

                <small class="text-muted d-block mt-1">
                    Password minimal 8 karakter
                </small>

                @error('password')
                    <span class="text-danger small d-block">{{ $message }}</span>
                @enderror

            </div>

            <!-- Konfirmasi Password -->
            <div class="form-group position-relative">
                <input type="password" name="password_confirmation" id="password_confirmation"
                    class="form-control form-control-user"
                    placeholder="Konfirmasi Password" required>

                <span toggle="#password_confirmation" class="toggle-password"
                    style="position:absolute; right:15px; top:50%; transform:translateY(-50%); cursor:pointer;">
                    
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="#4e73df" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M1.5 12s4.5-7.5 10.5-7.5S22.5 12 22.5 12 18 19.5 12 19.5 1.5 12 1.5 12z" />
                        <circle cx="12" cy="12" r="3" />
                    </svg>

                </span>
            </div>

            <!-- Submit -->
            <button type="submit" class="btn btn-primary btn-user btn-block">
                Daftar
            </button>
        </form>

        <hr>

        <div class="text-center">
            <a class="small text-primary" href="{{ route('login') }}">Sudah punya akun? Masuk!</a>
        </div>
        <div class="text-center mt-1">
            <a class="small text-secondary" href="{{ route('home') }}">Kembali ke Halaman Utama</a>
        </div>

    </div>
</div>

<!-- SCRIPT -->
<script>
document.querySelectorAll('.toggle-password').forEach(function (el) {
    el.addEventListener('click', function () {
        let input = document.querySelector(this.getAttribute('toggle'));

        if (input.type === "password") {
            input.type = "text";
            this.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="#4e73df" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3 3l18 18M10.5 10.5a3 3 0 004.24 4.24M9.88 5.09A9.77 9.77 0 0112 4.5c6 0 10.5 7.5 10.5 7.5a21.9 21.9 0 01-4.21 5.17M6.53 6.53A21.88 21.88 0 001.5 12s4.5 7.5 10.5 7.5c1.61 0 3.1-.34 4.44-.94" />
            </svg>`;
        } else {
            input.type = "password";
            this.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="#4e73df" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M1.5 12s4.5-7.5 10.5-7.5S22.5 12 22.5 12 18 19.5 12 19.5 1.5 12 1.5 12z" />
                <circle cx="12" cy="12" r="3" />
            </svg>`;
        }
    });
});
</script>
@endsection