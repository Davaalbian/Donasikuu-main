@extends('layouts.app')

@section('content')
<div class="container">

    <h3>Edit Data Pengguna</h3>

    <form action="{{ route('data_pengguna.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="name" class="form-control" 
                   value="{{ $user->name }}">
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" 
                   value="{{ $user->email }}">
        </div>

        <div class="mb-3">
            <label>No HP</label>
            <input type="text" name="no_telp" class="form-control" 
                   value="{{ $user->no_telp }}">
        </div>

        <div class="mb-3">
            <label>Alamat</label>
            <textarea name="alamat" class="form-control">{{ $user->alamat }}</textarea>
        </div>

        <button class="btn btn-primary">Simpan</button>
        <a href="{{ route('data_pengguna.index') }}" class="btn btn-secondary">Kembali</a>

    </form>

</div>
@endsection