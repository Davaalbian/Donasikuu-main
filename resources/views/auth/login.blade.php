@extends('layouts.auth')

@section('title', 'Login - Donasiku')

@section('content')
<div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-5">

        <!-- Logo + Judul -->
        <div class="text-center mb-4">
            <img src="{{ asset('assets/img/Logodonasi.png') }}" alt="Logo" class="mb-2" style="width:60px; height:60px;">
            <h1 class="h4 text-gray-900 font-weight-bold">Selamat Datang!</h1>
            <p class="text-gray-600 small">Masuk untuk mengakses dashboard Donasiku</p>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        @endif
        
        <!-- Form Login -->
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div class="form-group">
                <input type="email" name="email" 
                    class="form-control form-control-user @error('email') is-invalid @enderror" 
                    placeholder="Email" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password -->
            <div class="form-group position-relative">
                <input type="password" name="password" id="password"
                    class="form-control form-control-user @error('password') is-invalid @enderror"
                    placeholder="Password" required>

                <span toggle="#password" class="toggle-password"
                    style="position:absolute; right:15px; top:50%; transform:translateY(-50%); cursor:pointer;">
                    
                    <!-- Eye Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="#4e73df" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M1.5 12s4.5-7.5 10.5-7.5S22.5 12 22.5 12 18 19.5 12 19.5 1.5 12 1.5 12z" />
                        <circle cx="12" cy="12" r="3" />
                    </svg>

                </span>

                @error('password')
                    <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="form-group d-flex justify-content-between align-items-center">
                <div class="custom-control custom-checkbox small">
                    <input type="checkbox" class="custom-control-input" id="remember" name="remember">
                    <label class="custom-control-label" for="remember">Ingat Saya</label>
                </div>

                <div>
                    <a href="{{ route('password.request') }}" class="small text-primary">
                        Lupa Password?
                    </a>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary btn-user btn-block">
                Masuk
            </button>
        </form>

        <hr>

        <!-- Links -->
        <div class="text-center">
            <a class="small text-primary" href="{{ route('register') }}">Belum punya akun? Daftar!</a>
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