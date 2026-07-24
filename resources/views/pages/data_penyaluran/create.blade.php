@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <h1 class="h3 mb-3 text-gray-800">Tambah Penyaluran</h1>

    <div class="card shadow">
        <div class="card-body">

            <form action="{{ route('data_penyaluran.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- DONASI --}}
                <div class="form-group">
                    <label>Nama Donasi</label>
                    <select name="id_donasi" class="form-control" required>
                        <option value="">-- Pilih Donasi --</option>
                        @foreach($donasi as $d)
                            <option value="{{ $d->id }}"
                                    data-sisa="{{ $d->sisa }}">
                                {{ $d->nama_barang }} (Sisa: {{ $d->sisa }})
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- PENERIMA --}}
                <div class="form-group">
                    <label>Penerima</label>
                    <select name="id_penerima" class="form-control" required>
                        <option value="">-- Pilih Penerima --</option>
                        @foreach($penerima as $p)
                            <option value="{{ $p->id }}">
                                {{ $p->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Jumlah Disalurkan</label>
                    <input type="number"
                        name="jumlah_disalurkan"
                        class="form-control"
                        min="1"
                        required>
                </div>
                <div id="warningJumlah"
                    class="alert alert-danger mt-2"
                    style="display:none;">
                </div>

                {{-- TANGGAL --}}
                <div class="form-group">
                    <label>Tanggal Penyaluran</label>
                    <input type="date" name="tanggal_penyaluran" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Lokasi Penyaluran</label>
                    <input type="text"
                        name="lokasi"
                        class="form-control"
                        placeholder="Masukkan lokasi penyaluran">
                </div>

                <div class="form-group">
                    <label>Status Penyaluran</label>
                    <select name="status" class="form-control">
                        <option value="pending">Pending</option>
                        <option value="selesai">Selesai</option>
                    </select>
                </div>

                {{-- FOTO BUKTI --}}
                <div class="form-group">
                    <label>
                        Foto Bukti Penyaluran
                        <span class="text-danger">*</span>
                    </label>

                    <!-- Preview Foto -->
                    <div class="mb-2">
                        <img id="previewFoto"
                            src="#"
                            alt="Preview Foto"
                            class="img-thumbnail"
                            style="max-width: 250px; display: none;">
                    </div>

                    <input type="file"
                        name="bukti_foto"
                        id="bukti_foto"
                        class="form-control"
                        accept=".jpg,.jpeg,.png"
                        required>

                    <small class="text-danger">
                        Wajib diupload. Format yang diperbolehkan JPG, JPEG, dan PNG dengan ukuran maksimal 2 MB.
                    </small>
                </div>

                <div class="d-flex" style="justify-content: flex-start !important; gap: 12px;">
                    <a href="{{ route('data_penyaluran.index') }}" class="btn btn-secondary">
                        Batal
                    </a>

                    <button type="submit" class="btn btn-primary">
                        Simpan
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>

@push('scripts')
<script>
document.getElementById('bukti_foto').addEventListener('change', function(e) {

    const file = e.target.files[0];
    const preview = document.getElementById('previewFoto');

    if (file) {
        const reader = new FileReader();

        reader.onload = function(event) {
            preview.src = event.target.result;
            preview.style.display = 'block';
        };

        reader.readAsDataURL(file);
    } else {
        preview.style.display = 'none';
    }
});
</script>
<script>
const donasiSelect = document.querySelector('[name="id_donasi"]');
const jumlahInput = document.querySelector('[name="jumlah_disalurkan"]');
const btnSubmit = document.querySelector('button[type="submit"]');
const warningBox = document.getElementById('warningJumlah');

function cekJumlah() {

    const selectedOption =
        donasiSelect.options[donasiSelect.selectedIndex];

    const sisa =
        parseInt(selectedOption.dataset.sisa || 0);

    const jumlah =
        parseInt(jumlahInput.value || 0);

    if (jumlah > sisa) {

        warningBox.style.display = 'block';
        warningBox.innerHTML =
            `Jumlah disalurkan (${jumlah}) melebihi stok tersedia (${sisa}).`;

        btnSubmit.disabled = true;

    } else {

        warningBox.style.display = 'none';
        btnSubmit.disabled = false;
    }
}

donasiSelect.addEventListener('change', cekJumlah);
jumlahInput.addEventListener('input', cekJumlah);
</script>
@endpush
@endsection