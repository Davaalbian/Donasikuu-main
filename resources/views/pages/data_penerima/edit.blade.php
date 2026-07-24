@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- HEADER -->
    <div class="mb-4">
        <h1 class="h3 text-gray-800">Edit Data Penerima</h1>
        <p class="text-muted small mb-0">
            Ubah data penerima bantuan di bawah ini
        </p>
    </div>

    <!-- CARD FORM -->
    <div class="card shadow">
        <div class="card-body">

            <form action="{{ route('data_penerima.update', $data_penerima->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Nama -->
                <div class="form-group mb-3">
                    <label>Nama Penerima</label>
                    <input type="text"
                           name="nama"
                           class="form-control @error('nama') is-invalid @enderror"
                           value="{{ old('nama', $data_penerima->nama) }}"
                           required>
                    @error('nama')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- No Telp -->
                <div class="form-group mb-3">
                    <label>No. Telepon</label>
                    <input type="text"
                           name="no_telp"
                           class="form-control @error('no_telp') is-invalid @enderror"
                           value="{{ old('no_telp', $data_penerima->no_telp) }}"
                           required>
                    @error('no_telp')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Alamat -->
                <div class="form-group mb-4">
                    <label>Alamat</label>
                    <textarea name="alamat"
                              rows="4"
                              class="form-control @error('alamat') is-invalid @enderror"
                              required>{{ old('alamat', $data_penerima->alamat) }}</textarea>
                    @error('alamat')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- BUTTON -->
                <div class="d-flex justify-content-start">

                    <a href="{{ route('data_penerima.index') }}"
                    class="btn btn-secondary"
                    style="margin-right: 12px;">
                        Kembali
                    </a>

                    <button type="submit" class="btn btn-primary">
                        Update Data
                    </button>

                </div>

            </form>

        </div>
    </div>

</div>
@endsection