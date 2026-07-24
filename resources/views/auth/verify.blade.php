@extends('layouts.auth')

@section('title', 'Verifikasi Email')

@section('content')

<div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-5">

        <!-- LOGO + TITLE -->
        <div class="text-center mb-4">
            <img src="{{ asset('assets/img/Logodonasi.png') }}" 
                 alt="Logo"
                 style="width:60px; height:60px;">
            
            <h1 class="h4 text-gray-900 font-weight-bold mt-2">
                Verifikasi Email
            </h1>

            <p class="text-muted small">
                Kami telah mengirim link verifikasi ke email kamu
            </p>
        </div>

        <!-- ALERT -->
        @if (session('message'))
            <div class="alert alert-success text-center">
                {{ session('message') }}
            </div>
        @endif

        <!-- INFO -->
        <div class="text-center mb-3">
            <p class="text-gray-700">
                Silakan cek email kamu (termasuk folder spam) untuk verifikasi akun.
            </p>
        </div>

        <!-- RESEND BUTTON -->
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <button type="submit" class="btn btn-primary btn-user btn-block">
                Kirim Ulang Email
            </button>
        </form>

        <hr>

        <!-- BACK LOGIN -->
        <div class="text-center">
            <form action="{{ route('back.login') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-link p-0">
                    Kembali ke Login
                </button>
            </form>
        </div>

    </div>
</div>

@endsection