@extends('layouts.auth')

@section('title', 'Reset Password - Donasiku')

@section('content')
<div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh;">

    <div class="card shadow-lg" style="width: 420px;">
        <div class="card-body p-4">

            <!-- LOGO -->
            <div class="text-center mb-3">
                <img src="{{ asset('assets/img/Logodonasi.png') }}" style="width:60px;">
            </div>

            <h4 class="text-center mb-2">Reset Password</h4>
            <p class="text-muted text-center" style="font-size: 14px;">
                Masukkan password baru Anda
            </p>

            {{-- ERROR --}}
            @if ($errors->any())
                <div class="alert alert-danger text-center">
                    {{ $errors->first() }}
                </div>
            @endif

            {{-- SUCCESS --}}
            @if (session('status'))
                <div class="alert alert-success text-center">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.store') }}">
                @csrf

                <!-- TOKEN -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- EMAIL -->
                <div class="form-group">
                    <input type="email" name="email"
                        class="form-control text-center"
                        value="{{ old('email', $request->email) }}"
                        required>
                </div>

                <!-- PASSWORD -->
                <div class="form-group position-relative">
                    <input type="password" id="password" name="password"
                        class="form-control"
                        placeholder="Password Baru"
                        required>

                    <span toggle="#password" class="toggle-password"
                        style="position:absolute; right:15px; top:50%; transform:translateY(-50%); cursor:pointer;">
                        
                        <!-- EYE -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none"
                            viewBox="0 0 24 24" stroke="#4e73df" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M1.5 12s4.5-7.5 10.5-7.5S22.5 12 22.5 12 18 19.5 12 19.5 1.5 12 1.5 12z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                    </span>
                </div>

                <!-- CONFIRM PASSWORD -->
                <div class="form-group position-relative">
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        class="form-control"
                        placeholder="Konfirmasi Password"
                        required>

                    <span toggle="#password_confirmation" class="toggle-password"
                        style="position:absolute; right:15px; top:50%; transform:translateY(-50%); cursor:pointer;">
                        
                        <!-- EYE -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none"
                            viewBox="0 0 24 24" stroke="#4e73df" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M1.5 12s4.5-7.5 10.5-7.5S22.5 12 22.5 12 18 19.5 12 19.5 1.5 12 1.5 12z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                    </span>
                </div>

                <!-- BUTTON -->
                <div class="d-flex justify-content-center mt-3">
                    <button type="submit" class="btn btn-primary px-4">
                        Reset Password
                    </button>
                </div>

            </form>

            <!-- BACK -->
            <div class="text-center mt-3">
                <a href="{{ route('login') }}" class="small text-primary">
                    ← Kembali ke Login
                </a>
            </div>

        </div>
    </div>

</div>

<!-- TOGGLE SCRIPT (FIXED) -->
<script>
document.querySelectorAll('.toggle-password').forEach(function (el) {
    el.addEventListener('click', function () {

        let input = document.querySelector(this.getAttribute('toggle'));

        let show = input.type === "password";
        input.type = show ? "text" : "password";

        this.innerHTML = show
            ? `<!-- EYE OFF -->
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none"
                viewBox="0 0 24 24" stroke="#4e73df" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3 3l18 18M10.5 10.5a3 3 0 004.24 4.24M9.88 5.09A9.77 9.77 0 0112 4.5c6 0 10.5 7.5 10.5 7.5a21.9 21.9 0 01-4.21 5.17M6.53 6.53A21.88 21.88 0 001.5 12s4.5 7.5 10.5 7.5c1.61 0 3.1-.34 4.44-.94"/>
            </svg>`
            : `<!-- EYE -->
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none"
                viewBox="0 0 24 24" stroke="#4e73df" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M1.5 12s4.5-7.5 10.5-7.5S22.5 12 22.5 12 18 19.5 12 19.5 1.5 12 1.5 12z"/>
                <circle cx="12" cy="12" r="3"/>
            </svg>`;
    });
});
</script>
@endsection