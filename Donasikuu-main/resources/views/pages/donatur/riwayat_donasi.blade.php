@extends('layouts.donatur')

@section('title', '
')

@section('content')
<div class="container-fluid">

    {{-- HEADER --}}
    <div class="mb-4">
        <h1 class="h3 mb-1 text-gray-800">Riwayat Donasi</h1>
        <p class="text-muted">
            Daftar semua donasi yang telah kamu kirim
        </p>
    </div>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- CARD --}}
    <div class="card shadow mb-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover mb-0" style="font-size: 13.5px;">
                    <thead class="bg-primary text-white text-center">
                        <tr>
                            <th class="align-middle" style="width:45px;">No</th>
                            <th class="align-middle" style="min-width:160px;">Nama Barang</th>
                            <th class="align-middle" style="width:55px;">Jml</th>
                            <th class="align-middle" style="width:110px;">Kondisi</th>
                            <th class="align-middle" style="width:130px;">Pengiriman</th>
                            <th class="align-middle" style="width:100px;">Tanggal</th>
                            <th class="align-middle" style="width:65px;">Foto</th>
                            <th class="align-middle" style="width:105px;">Status</th>
                            <th class="align-middle" style="width:150px;">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($donasi as $item)
                        <tr style="vertical-align: middle;">

                            <td class="text-center text-muted">{{ $loop->iteration }}</td>

                            <td class="font-weight-bold">{{ $item->nama_barang }}</td>

                            <td class="text-center font-weight-bold">{{ $item->jumlah }}</td>

                            <td class="text-center">{{ $item->kondisi }}</td>

                            <td class="text-center">{{ $item->metode_pengiriman }}</td>

                            <td class="text-center text-muted" style="font-size:12.5px;">
                                {{ \Carbon\Carbon::parse($item->tanggal_pengiriman)->format('d M Y') }}
                            </td>

                            <td class="text-center">
                                @if($item->foto)
                                    <img src="{{ asset('uploads/donasi/' . $item->foto) }}"
                                        width="46" height="46"
                                        style="object-fit:cover; border-radius:6px; cursor:pointer; border:2px solid #dee2e6;"
                                        data-toggle="modal"
                                        data-target="#modalFoto"
                                        onclick="setFoto(this.src)">
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>

                            <td class="text-center">
                                @if($item->status_donasi == 'pending')
                                    <span class="badge badge-warning px-2 py-1">Pending</span>

                                @elseif($item->status_donasi == 'disetujui')
                                    <span class="badge badge-info px-2 py-1">Diproses</span>

                                @elseif($item->status_donasi == 'disalurkan')
                                    <span class="badge badge-primary px-2 py-1">Disalurkan</span>

                                @elseif($item->status_donasi == 'selesai')
                                    <span class="badge badge-success px-2 py-1">Selesai</span>

                                @elseif($item->status_donasi == 'ditolak')
                                    <span class="badge badge-danger px-2 py-1">Ditolak</span>

                                @else
                                    <span class="badge badge-secondary px-2 py-1">-</span>
                                @endif
                            </td>

                            <td class="text-center">
                                @if($item->status_donasi == 'pending')
                                    <div class="d-flex justify-content-center align-items-center" style="gap:5px;">

                                        <a href="{{ route('donatur.donasi.edit', $item->id) }}"
                                        class="btn btn-sm btn-warning px-3">
                                            Edit
                                        </a>

                                        <form action="{{ route('donatur.donasi.destroy', $item->id) }}"
                                            method="POST" style="margin:0;">
                                            @csrf @method('DELETE')
                                            <button type="button"
                                                    class="btn btn-sm btn-danger px-3 btn-hapus">
                                                Hapus
                                            </button>
                                        </form>

                                    </div>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">
                                Belum ada donasi
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- MODAL FOTO -->
<div class="modal fade" id="modalFoto" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Bukti Foto Donasi</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body text-center">
                <img id="fotoPreview" src="" class="img-fluid rounded">
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function setFoto(src) {
    document.getElementById('fotoPreview').src = src;
}

// reset modal saat ditutup
$('#modalFoto').on('hidden.bs.modal', function () {
    document.getElementById('fotoPreview').src = '';
});
</script>
@endpush