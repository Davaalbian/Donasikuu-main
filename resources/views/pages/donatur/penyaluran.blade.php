@extends('layouts.donatur')

@section('title', 'Data Penyaluran Saya')

@section('content')
<div class="container-fluid">

    {{-- HEADER --}}
    <div class="mb-4">
        <h1 class="h3 mb-1 text-gray-800">Data Penyaluran Saya</h1>
        <p class="text-muted">
            Berikut daftar barang yang sudah disalurkan oleh admin kepada penerima
        </p>
    </div>

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
                            <th class="align-middle" style="min-width:140px;">Penerima</th>
                            <th class="align-middle" style="width:110px;">Tanggal</th>
                            <th class="align-middle" style="width:90px;">Foto Bukti</th>
                            <th class="align-middle" style="width:105px;">Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($data as $i => $d)
                        <tr style="vertical-align: middle;">

                            <td class="text-center text-muted">{{ $i + 1 }}</td>

                            <td class="font-weight-bold">{{ $d->donasi->nama_barang ?? '-' }}</td>

                            <td class="text-center font-weight-bold">{{ $d->jumlah_disalurkan }}</td>

                            <td>{{ $d->penerima->nama ?? '-' }}</td>

                            <td class="text-center text-muted" style="font-size:12.5px;">
                                {{ \Carbon\Carbon::parse($d->tanggal_penyaluran)->format('d M Y') }}
                            </td>

                            <td class="text-center">
                                @if($d->bukti_foto)
                                    <img src="{{ asset('uploads/penyaluran/' . $d->bukti_foto) }}"
                                        width="46" height="46"
                                        style="object-fit:cover; border-radius:6px; cursor:pointer; border:2px solid #dee2e6;"
                                        data-toggle="modal"
                                        data-target="#fotoModal{{ $d->id }}">
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>

                            <td class="text-center">
                                <span class="badge badge-success px-2 py-1">Selesai</span>
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                Belum ada penyaluran
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


{{-- MODAL FOTO (HARUS DI LUAR TABLE) --}}
@foreach($data as $d)
@if($d->bukti_foto)

<div class="modal fade" id="fotoModal{{ $d->id }}" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">

            {{-- HEADER --}}
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    Foto Bukti Penyaluran
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            {{-- BODY --}}
            <div class="modal-body text-center p-4" style="background:#f8f9fc;">
                <img src="{{ asset('uploads/penyaluran/'.$d->bukti_foto) }}"
                     class="img-fluid rounded shadow"
                     style="max-height: 500px;">
            </div>

        </div>
    </div>
</div>

@endif
@endforeach

@endsection