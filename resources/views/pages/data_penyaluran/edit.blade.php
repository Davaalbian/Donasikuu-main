@extends('layouts.app')

@section('content')

<div class="container-fluid">

<div class="mb-3">
    <h1 class="h3 mb-1 text-gray-800">Edit Data Penyaluran</h1>
    <p class="text-muted small mb-2">
        Ubah data distribusi barang dari donatur ke penerima dan bukti dokumentasi
    </p>
</div>

<div class="card shadow">
    <div class="card-body">

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('data_penyaluran.update', $item->id) }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <div class="form-group mb-3">
                <label>Barang Donasi</label>
                <select name="id_donasi" class="form-control" required>
                    <option value="">-- Pilih Barang --</option>
                    @foreach($donasi as $d)
                        <option value="{{ $d->id }}"
                            {{ $item->id_donasi == $d->id ? 'selected' : '' }}>
                            {{ $d->nama_barang }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-3">
                <label>Penerima</label>
                <select name="id_penerima" class="form-control" required>
                    <option value="">-- Pilih Penerima --</option>
                    @foreach($penerima as $p)
                        <option value="{{ $p->id }}"
                            {{ $item->id_penerima == $p->id ? 'selected' : '' }}>
                            {{ $p->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-3">
                <label>Jumlah Disalurkan</label>
                <input type="number"
                    name="jumlah_disalurkan"
                    class="form-control"
                    min="1"
                    value="{{ $item->jumlah_disalurkan }}"
                    required>
            </div>

            <div class="form-group mb-3">
                <label>Tanggal Penyaluran</label>
                <input type="date"
                       name="tanggal_penyaluran"
                       class="form-control"
                       value="{{ $item->tanggal_penyaluran }}"
                       required>
            </div>

            <div class="form-group mb-3">
                <label>Lokasi Penyaluran</label>
                <input type="text"
                    name="lokasi"
                    class="form-control"
                    value="{{ $item->lokasi }}">
            </div>

            <div class="form-group mb-3">
                <label>Status Penyaluran</label>
                <select name="status" class="form-control">

                    <option value="pending"
                        {{ $item->status == 'pending' ? 'selected' : '' }}>
                        Pending
                    </option>

                    <option value="selesai"
                        {{ $item->status == 'selesai' ? 'selected' : '' }}>
                        Selesai
                    </option>

                </select>
            </div>

            <div class="form-group mb-3">
                <label>Foto Bukti (Opsional)</label>

                @if($item->bukti_foto)
                    <div class="mb-2">
                        <img src="{{ asset('uploads/penyaluran/'.$item->bukti_foto) }}"
                             width="150"
                             class="img-thumbnail">
                    </div>
                @endif

                <input type="file"
                       name="bukti_foto"
                       class="form-control">
                <small class="text-muted">
                    Kosongkan jika tidak ingin mengganti foto.
                </small>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    Update Data
                </button>

                <a href="{{ route('data_penyaluran.index') }}"
                   class="btn btn-secondary">
                    Kembali
                </a>
            </div>

        </form>

    </div>
</div>

</div>
@endsection
