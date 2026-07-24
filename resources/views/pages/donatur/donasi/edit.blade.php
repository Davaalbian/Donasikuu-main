@extends('layouts.donatur')

@section('title', 'Edit Donasi')

@section('content')
<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Edit Donasi</h1>

    <div class="card shadow">
        <div class="card-body">

            <form action="{{ route('donatur.donasi.update', $item->id) }}" 
                  method="POST" 
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- KATEGORI --}}
                <div class="form-group mb-3">
                    <label>Kategori</label>
                    <select name="id_kategori" class="form-control" required>
                        @foreach($kategori as $k)
                            <option value="{{ $k->id }}" 
                                {{ $item->id_kategori == $k->id ? 'selected' : '' }}>
                                {{ $k->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- NAMA BARANG --}}
                <div class="form-group mb-3">
                    <label>Nama Barang</label>
                    <input type="text" name="nama_barang" class="form-control"
                           value="{{ $item->nama_barang }}" required>
                </div>

                {{-- JUMLAH --}}
                <div class="form-group mb-3">
                    <label>Jumlah</label>
                    <input type="number" id="jumlah" name="jumlah" class="form-control"
                           value="{{ $item->jumlah }}" required>
                </div>

                {{-- KONDISI --}}
                <div class="form-group mb-3">
                    <label>Kondisi</label>
                    <select name="kondisi" class="form-control" required>
                        <option value="Baru" {{ $item->kondisi == 'Baru' ? 'selected' : '' }}>Baru</option>
                        <option value="Layak Pakai" {{ $item->kondisi == 'Layak Pakai' ? 'selected' : '' }}>Layak Pakai</option>
                        <option value="Perlu Perbaikan" {{ $item->kondisi == 'Perlu Perbaikan' ? 'selected' : '' }}>Perlu Perbaikan</option>
                    </select>
                </div>

                {{-- METODE PENGIRIMAN --}}
                <div class="form-group mb-3">
                    <label>Metode Pengiriman</label>

                    <select name="metode_pengiriman" id="metode_pengiriman" class="form-control" required>
                        <option value="Antar Langsung"
                            {{ $item->metode_pengiriman == 'Antar Langsung' ? 'selected' : '' }}>
                            Antar Langsung
                        </option>

                        <option value="Dijemput pihak RW"
                            {{ $item->metode_pengiriman == 'Dijemput pihak RW' ? 'selected' : '' }}>
                            Dijemput pihak RW
                        </option>
                    </select>

                    <small class="text-muted">
                        * Penjemputan hanya tersedia jika jumlah minimal 10 barang
                    </small>

                    {{-- WARNING --}}
                    <div id="warningMetode" class="alert alert-danger mt-2 d-none">
                        ❌ Jumlah kurang dari 10, tidak bisa memilih “Dijemput pihak RW”
                    </div>
                </div>

                {{-- FOTO --}}
                <div class="form-group mb-3">
                    <label>Foto</label><br>

                    @if($item->foto)
                        <img src="{{ asset('uploads/donasi/' . $item->foto) }}" 
                             width="100" class="mb-2">
                    @endif

                    <input type="file" name="foto" class="form-control">
                </div>

                {{-- TANGGAL --}}
                <div class="form-group mb-3">
                    <label>Tanggal Pengiriman</label>
                    <input type="date" name="tanggal_pengiriman" class="form-control"
                           value="{{ $item->tanggal_pengiriman }}" required>
                </div>

                {{-- BUTTON --}}
                <div class="d-flex mt-4" style="gap: 15px;">
                    <a href="{{ route('donatur.donasi.index') }}" class="btn btn-secondary">
                        Kembali
                    </a>

                    <button type="submit" class="btn btn-primary">
                        Update
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const jumlahInput = document.getElementById('jumlah');
    const metodeSelect = document.getElementById('metode_pengiriman');
    const warning = document.getElementById('warningMetode');

    function checkRule() {
        let jumlah = parseInt(jumlahInput.value || 0);

        if (jumlah < 10) {

            // kalau sudah pilih dijemput → paksa reset
            if (metodeSelect.value === 'Dijemput pihak RW') {
                metodeSelect.value = 'Antar Langsung';
                warning.classList.remove('d-none');
            }

            // disable opsi jemput
            [...metodeSelect.options].forEach(opt => {
                if (opt.value === 'Dijemput pihak RW') {
                    opt.disabled = true;
                }
            });

        } else {
            warning.classList.add('d-none');

            [...metodeSelect.options].forEach(opt => {
                if (opt.value === 'Dijemput pihak RW') {
                    opt.disabled = false;
                }
            });
        }
    }

    jumlahInput.addEventListener('input', checkRule);
    checkRule();

});
</script>
@endpush