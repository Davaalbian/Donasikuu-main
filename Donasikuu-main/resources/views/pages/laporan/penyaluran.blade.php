@extends('layouts.app')

@section('title', 'Laporan Penyaluran')

@section('content')
<div class="container-fluid">

    {{-- HEADER --}}
    <div class="mb-4">
        <h1 class="h3 mb-2 text-gray-800">Laporan Penyaluran</h1>

        <div class="d-flex flex-wrap align-items-center" style="gap: 8px;">
            
            {{-- Tombol PDF --}}
            <a href="{{ route('laporan.penyaluran.pdf', ['rt' => request('rt')]) }}" 
               class="btn btn-danger btn-sm">
                <i class="fas fa-file-pdf mr-1"></i> Cetak PDF
            </a>

        </div>
    </div>

    {{-- RINGKASAN --}}
    <div class="mb-3">
        <span class="badge badge-primary px-3 py-2">
            Total Penyaluran: {{ $data->count() }}
        </span>

        <span class="badge badge-success px-3 py-2">
            Total Barang: {{ $data->sum('jumlah') }}
        </span>
    </div>

    {{-- TABEL --}}
    <div class="card shadow mb-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover mb-0" style="font-size: 13.5px;">
                    <thead class="bg-primary text-white text-center">
                        <tr>
                            <th class="align-middle" style="width:45px;">No</th>
                            <th class="align-middle" style="min-width:140px;">Penerima</th>
                            <th class="align-middle" style="min-width:160px;">Barang</th>
                            <th class="align-middle" style="width:55px;">Jml</th>
                            <th class="align-middle" style="min-width:160px;">Lokasi</th>
                            <th class="align-middle" style="width:105px;">Status</th>
                            <th class="align-middle" style="width:110px;">Tanggal</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($data as $i => $d)
                        <tr style="vertical-align: middle;">

                            <td class="text-center text-muted">{{ $i + 1 }}</td>

                            <td class="font-weight-bold">{{ $d->penerima->nama ?? '-' }}</td>

                            <td>{{ $d->donasi->nama_barang ?? '-' }}</td>

                            <td class="text-center font-weight-bold">{{ $d->donasi->jumlah ?? '-' }}</td>

                            <td style="white-space:normal; font-size:12.5px; color:#555;">
                                {{ $d->lokasi ?? '-' }}
                            </td>

                            <td class="text-center">
                                @if($d->status == 'pending')
                                    <span class="badge badge-warning px-2 py-1">Pending</span>
                                @elseif($d->status == 'selesai')
                                    <span class="badge badge-primary px-2 py-1">Disalurkan</span>
                                @endif
                            </td>

                            <td class="text-center text-muted" style="font-size:12.5px;">
                                {{ \Carbon\Carbon::parse($d->tanggal_penyaluran)->format('d M Y') }}
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                Tidak ada data laporan
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