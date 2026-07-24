@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- HEADER (samakan dengan edit) -->
    <div class="mb-4">
        <h1 class="h3 text-gray-800">Tambah Data Penerima</h1>
        <p class="text-muted small">
            Tambahkan data penerima bantuan baru
        </p>
    </div>

    <!-- CARD FORM -->
    <div class="card shadow">
        <div class="card-body">

            <form action="{{ route('data_penerima.store') }}" method="POST">
                @csrf

                <!-- Nama -->
                <div class="form-group mb-3">
                    <label>Nama Penerima</label>
                    <input type="text" 
                           name="nama" 
                           class="form-control"
                           placeholder="Masukkan nama penerima"
                           required>
                </div>

                <!-- No Telp -->
                <div class="form-group mb-3">
                    <label>No. Telepon</label>
                    <input type="text" 
                           name="no_telp" 
                           class="form-control"
                           placeholder="Contoh: 08123456789"
                           required>
                </div>

                <!-- Alamat -->
                <div class="form-group mb-4">
                    <label>Alamat</label>
                    <textarea name="alamat" 
                              rows="4" 
                              class="form-control"
                              placeholder="Masukkan alamat lengkap"
                              required></textarea>
                </div>

                <!-- BUTTON -->
                <div class="d-flex" style="justify-content: flex-start !important; gap: 12px;">
                    <a href="{{ route('data_penerima.index') }}" 
                    class="btn btn-secondary">
                        Kembali
                    </a>

                    <button type="submit" class="btn btn-primary">
                        Simpan
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection