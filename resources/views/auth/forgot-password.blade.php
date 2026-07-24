@extends('layouts.auth')

@section('title', 'Lupa Password - Donasiku')

@section('content')
<div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh;">

    <div class="card shadow-lg" style="width: 420px;">
        <div class="card-body p-4">

            <!-- LOGO -->
            <div class="text-center mb-3">
                <img src="{{ asset('assets/img/Logodonasi.png') }}"
                     alt="Logo"
                     style="width:60px; height:60px;">
            </div>

            <h4 class="text-center mb-2">Lupa Password</h4>

            <p class="text-muted text-center" style="font-size: 14px;">
                Masukkan email untuk menerima link reset password
            </p>

            {{-- STATUS --}}
            @if (session('status'))
                <div class="alert alert-success text-center">
                    {{ session('status') }}
                </div>
            @endif

            {{-- ERROR --}}
            @if ($errors->any())
                <div class="alert alert-danger text-center">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- EMAIL -->
                <div class="form-group">
                    <input type="email" name="email"
                        class="form-control text-center @error('email') is-invalid @enderror"
                        placeholder="Masukkan email..."
                        value="{{ old('email') }}"
                        required autofocus>

                    @error('email')
                        <span class="text-danger small d-block text-center">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <!-- BUTTON CENTER -->
                <div class="d-flex justify-content-center mt-3">
                    <button type="submit" class="btn btn-primary px-4">
                        Kirim Link Reset
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
@endsection