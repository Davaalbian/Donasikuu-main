@extends('layouts.donatur')

@section('title', 'Buat Donasi Baru')

@section('content')
<div class="container-fluid">

    <div class="mb-4">
        <h1 class="h3 mb-1 text-gray-800">Form Donasi</h1>
        <p class="text-muted">Silakan isi data donasi dengan lengkap</p>
    </div>

    {{-- PROFIL DONATUR --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Profil Donatur</h6>
        </div>
        <div class="card-body">

            @if (!$user->name || !$user->alamat || !$user->rt)
                <div class="alert alert-warning">
                    Profil Anda belum lengkap. Silakan lengkapi terlebih dahulu sebelum mengirim donasi.
                    <div class="mt-2">
                        <a href="{{ route('donatur.profil') }}" class="btn btn-sm btn-warning">
                            Lengkapi Profil
                        </a>
                    </div>
                </div>
            @endif

            <div class="row" style="font-size: 13.5px;">
                <div class="col-md-6">
                    <table class="table table-borderless table-sm mb-0">
                        <tr>
                            <td style="width:100px;" class="text-muted">Nama</td>
                            <td class="font-weight-bold">{{ $user->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Email</td>
                            <td>{{ $user->email ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">No Telp</td>
                            <td>{{ $user->no_telp ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-borderless table-sm mb-0">
                        <tr>
                            <td style="width:80px;" class="text-muted">RT</td>
                            <td>{{ $user->rt ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Alamat</td>
                            <td>{{ $user->alamat ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>

        </div>
    </div>

    {{-- FORM DONASI --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Isi Donasi Barang</h6>
        </div>
        <div class="card-body" style="font-size: 13.5px;">

            <form action="{{ route('donatur.donasi.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @php $profilLengkap = $user->name && $user->alamat && $user->rt; @endphp

                {{-- Kategori --}}
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label font-weight-bold">Kategori Barang</label>
                    <div class="col-sm-7">
                        <select name="id_kategori" class="form-control @error('id_kategori') is-invalid @enderror" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach ($kategori as $item)
                                <option value="{{ $item->id }}" {{ old('id_kategori') == $item->id ? 'selected' : '' }}>
                                    {{ $item->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_kategori')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Nama Barang --}}
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label font-weight-bold">Nama Barang</label>
                    <div class="col-sm-7">
                        <input type="text" name="nama_barang"
                            class="form-control @error('nama_barang') is-invalid @enderror"
                            value="{{ old('nama_barang') }}"
                            placeholder="Contoh: Baju Layak Pakai"
                            required>
                        @error('nama_barang')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Jumlah --}}
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label font-weight-bold">Jumlah</label>
                    <div class="col-sm-4">
                        <input type="number" name="jumlah" id="jumlah" min="1"
                            class="form-control @error('jumlah') is-invalid @enderror"
                            value="{{ old('jumlah') }}"
                            required>
                        @error('jumlah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Kondisi --}}
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label font-weight-bold">Kondisi Barang</label>
                    <div class="col-sm-5">
                        <select name="kondisi" class="form-control @error('kondisi') is-invalid @enderror" required>
                            <option value="">-- Pilih Kondisi --</option>
                            <option value="Baru"           {{ old('kondisi') == 'Baru'           ? 'selected' : '' }}>Baru</option>
                            <option value="Layak Pakai"    {{ old('kondisi') == 'Layak Pakai'    ? 'selected' : '' }}>Layak Pakai</option>
                            <option value="Perlu Perbaikan"{{ old('kondisi') == 'Perlu Perbaikan'? 'selected' : '' }}>Perlu Perbaikan</option>
                        </select>
                        @error('kondisi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Metode Pengiriman --}}
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label font-weight-bold">Metode Pengiriman</label>
                    <div class="col-sm-5">
                        <select name="metode_pengiriman" id="metode_pengiriman"
                            class="form-control @error('metode_pengiriman') is-invalid @enderror" required>
                            <option value="">-- Pilih Metode --</option>
                            <option value="Antar Langsung"   {{ old('metode_pengiriman') == 'Antar Langsung'   ? 'selected' : '' }}>Antar Langsung</option>
                            <option value="Dijemput pihak RW" id="opsi_jemput" {{ old('metode_pengiriman') == 'Dijemput pihak RW' ? 'selected' : '' }}>Dijemput pihak RW</option>
                        </select>
                        <small class="text-muted">Penjemputan hanya tersedia jika jumlah minimal 10 barang</small>
                        @error('metode_pengiriman')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Foto --}}
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label font-weight-bold">
                        Foto Barang <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-7">
                        <input type="file" name="foto"
                            class="form-control-file @error('foto') is-invalid @enderror"
                            accept="image/jpg,image/jpeg,image/png"
                            onchange="previewFoto(this)"
                            required>
                        <small class="text-muted">Format: JPG, JPEG, PNG. Maks 2MB (Wajib diunggah)</small>
                        @error('foto')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror

                        <div id="preview-container" class="mt-2" style="display:none;">
                            <img id="preview-img"
                                 style="max-width:160px; border-radius:8px; border:2px solid #dee2e6;">
                        </div>
                    </div>
                </div>

                {{-- Tanggal --}}
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label font-weight-bold">Tanggal Pengiriman</label>
                    <div class="col-sm-4">
                        <input type="date" name="tanggal_pengiriman"
                            class="form-control @error('tanggal_pengiriman') is-invalid @enderror"
                            value="{{ old('tanggal_pengiriman') }}"
                            min="{{ date('Y-m-d') }}"
                            required>
                        @error('tanggal_pengiriman')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <hr>

                <div class="form-group row mb-0">
                    <div class="col-sm-9 offset-sm-3">
                        <button type="submit" class="btn btn-primary px-4"
                            {{ !$profilLengkap ? 'disabled' : '' }}>
                            Kirim Donasi
                        </button>
                        <a href="{{ route('donatur.donasi.index') }}" class="btn btn-secondary ml-2 px-4">
                            Batal
                        </a>
                    </div>
                </div>

            </form>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
function previewFoto(input) {
    const file = input.files[0];
    const container = document.getElementById('preview-container');
    const img = document.getElementById('preview-img');

    if (file) {
        const reader = new FileReader();
        reader.onload = e => {
            img.src = e.target.result;
            container.style.display = 'block';
        };
        reader.readAsDataURL(file);
    } else {
        img.src = '';
        container.style.display = 'none';
    }
}

document.addEventListener('DOMContentLoaded', function () {
    const form         = document.querySelector('form');
    const jumlahInput  = document.getElementById('jumlah');
    const metodeSelect = document.getElementById('metode_pengiriman');
    const opsiJemput   = document.querySelector('option[value="Dijemput pihak RW"]');

    function checkMetode() {
        const jumlah = parseInt(jumlahInput.value || 0);
        opsiJemput.disabled = jumlah < 10;
        if (jumlah < 10 && metodeSelect.value === 'Dijemput pihak RW') {
            metodeSelect.value = '';
        }
    }

    jumlahInput.addEventListener('input', checkMetode);
    checkMetode();

    form.addEventListener('submit', function (e) {
        if (metodeSelect.value === 'Dijemput pihak RW' && parseInt(jumlahInput.value || 0) < 10) {
            e.preventDefault();
            alert('Penjemputan hanya bisa jika jumlah minimal 10 barang.');
        }
    });
});
</script>
@endpush