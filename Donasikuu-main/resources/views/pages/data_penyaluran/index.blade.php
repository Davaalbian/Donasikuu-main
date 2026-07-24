@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- Judul -->
    <div class="mb-3"> 
        <h1 class="h3 mb-1 text-gray-800">Data Penyaluran</h1> 
        <p class="text-muted small mb-2">
            Data distribusi barang dari donatur ke penerima dan bukti dokumentasi
        </p>

        <a href="{{ route('data_penyaluran.create') }}" class="btn btn-success btn-sm shadow-sm">
            + Tambah Penyaluran
        </a>
    </div>

    <!-- Notifikasi -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Tabel -->
    <div class="card shadow mb-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover mb-0" style="font-size: 13.5px;">
                    <thead class="bg-primary text-white text-center">
                        <tr>
                            <th class="align-middle" style="width:45px;">No</th>
                            <th class="align-middle" style="min-width:160px;">Nama Barang</th>
                            <th class="align-middle" style="min-width:140px;">Penerima</th>
                            <th class="align-middle" style="width:100px;">Tanggal</th>
                            <th class="align-middle" style="min-width:160px;">Lokasi</th>
                            <th class="align-middle" style="width:105px;">Status</th>
                            <th class="align-middle" style="width:90px;">Foto Bukti</th>
                            <th class="align-middle" style="width:140px;">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                    @forelse($data_penyaluran as $item)
                    <tr style="vertical-align: middle;">

                        <td class="text-center text-muted">{{ $loop->iteration }}</td>

                        <td class="font-weight-bold">{{ $item->donasi->nama_barang ?? '-' }}</td>

                        <td>{{ $item->penerima->nama ?? '-' }}</td>

                        <td class="text-center text-muted" style="font-size:12.5px;">
                            {{ \Carbon\Carbon::parse($item->tanggal_penyaluran)->format('d M Y') }}
                        </td>

                        <td style="white-space:normal; font-size:12.5px; color:#555;">
                            {{ $item->lokasi ?? '-' }}
                        </td>

                        <td class="text-center">
                            @if($item->status == 'pending')
                                <span class="badge badge-warning px-2 py-1">Pending</span>
                            @else
                                <span class="badge badge-primary px-2 py-1">Disalurkan</span>
                            @endif
                        </td>

                        <td class="text-center">
                            @if($item->bukti_foto)
                                <img src="{{ asset('uploads/penyaluran/' . $item->bukti_foto) }}"
                                    width="46" height="46"
                                    style="object-fit:cover; border-radius:6px; cursor:pointer; border:2px solid #dee2e6;"
                                    data-toggle="modal"
                                    data-target="#modalFoto{{ $item->id }}">
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>

                        <td class="text-center">
                            <div class="d-flex justify-content-center align-items-center" style="gap:5px;">

                                <a href="{{ route('data_penyaluran.edit', $item->id) }}"
                                class="btn btn-sm btn-warning px-3">
                                    Edit
                                </a>

                                <form action="{{ route('data_penyaluran.destroy', $item->id) }}"
                                    method="POST" style="margin:0;">
                                    @csrf @method('DELETE')
                                    <button type="button"
                                            class="btn btn-sm btn-danger px-3 btn-hapus">
                                        Hapus
                                    </button>
                                </form>

                            </div>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            Data penyaluran tidak tersedia
                        </td>
                    </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection

@foreach($data_penyaluran as $item)
@if($item->bukti_foto)

<div class="modal fade" id="modalFoto{{ $item->id }}" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">

            <!-- HEADER -->
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Foto Bukti Penyaluran</h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <!-- BODY -->
            <div class="modal-body text-center" style="background:#f8f9fc;">
                <img src="{{ asset('uploads/penyaluran/'.$item->bukti_foto) }}"
                     class="img-fluid rounded shadow"
                     style="max-height: 500px;">
            </div>

        </div>
    </div>
</div>

@endif
@endforeach