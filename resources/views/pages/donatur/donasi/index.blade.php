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
    <div class="card shadow">
        <div class="card-body table-responsive">

            <table class="table table-bordered table-hover">
                <thead class="bg-primary text-white text-center">
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Jumlah</th>
                        <th>Kondisi</th>
                        <th>Pengiriman</th>
                        <th>Tanggal</th>
                        <th>Foto</th>
                        <th>Status</th>
                        <th width="160">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($donasi as $item)
                        <tr>

                            <td class="text-center align-middle">{{ $loop->iteration }}</td>

                            <td class="align-middle">{{ $item->nama_barang }}</td>

                            <td class="text-center align-middle">{{ $item->jumlah }}</td>

                            <td class="text-center align-middle">{{ $item->kondisi }}</td>

                            <td class="text-center align-middle">{{ $item->metode_pengiriman }}</td>

                            <td class="text-center align-middle">
                                {{ \Carbon\Carbon::parse($item->tanggal_pengiriman)->format('d-m-Y') }}
                            </td>

                            {{-- FOTO --}}
                            <td class="text-center align-middle">
                                @if($item->foto)
                                    <img src="{{ asset('uploads/donasi/' . $item->foto) }}"
                                        width="60"
                                        class="img-thumbnail"
                                        style="cursor:pointer"
                                        data-toggle="modal"
                                        data-target="#modalFoto"
                                        onclick="setFoto(this.src)">
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>

                            {{-- STATUS --}}
                            <td class="text-center align-middle">
                                @if($item->status_donasi == 'pending')
                                    <span class="badge badge-warning px-3 py-2 text-white">Pending</span>

                                @elseif($item->status_donasi == 'disetujui')
                                    <span class="badge bg-info px-3 py-2 text-white">Diproses</span>

                                @elseif($item->status_donasi == 'disalurkan')
                                    <span class="badge bg-primary px-3 py-2 text-white">Disalurkan</span>

                                @elseif($item->status_donasi == 'selesai')
                                    <span class="badge badge-success px-3 py-2 text-white">Selesai</span>

                                @elseif($item->status_donasi == 'ditolak')
                                    <span class="badge badge-danger px-3 py-2 text-white">Ditolak</span>

                                @else
                                    <span class="badge bg-secondary px-3 py-2 text-white">-</span>
                                @endif
                            </td>
                            
                            {{-- AKSI --}}
                            <td class="text-center align-middle">
                                @if($item->status_donasi == 'pending')

                                    <div style="display:flex; justify-content:center; align-items:center; gap:8px;">

                                        <a href="{{ route('donatur.donasi.edit', $item->id) }}"
                                           class="btn btn-sm btn-warning px-3">
                                            Edit
                                        </a>

                                        <form action="{{ route('donatur.donasi.destroy', $item->id) }}"
                                              method="POST"
                                              style="margin:0;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn btn-sm btn-danger px-3"
                                                    onclick="return confirm('Yakin mau hapus donasi ini?')">
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
                            <td colspan="9" class="text-center text-muted align-middle">
                                Belum ada donasi
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>

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