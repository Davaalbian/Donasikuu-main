@extends('layouts.app')

@section('title', 'Laporan Donasi')

@section('content')
<div class="container-fluid">

    <div class="mb-4">
        <h1 class="h3 mb-2 text-gray-800">Laporan Donasi</h1>

        <div class="d-flex flex-wrap align-items-center" style="gap: 8px;">
            
            {{-- Tombol PDF --}}
            <a href="{{ route('laporan.donasi.pdf', ['rt' => request('rt')]) }}" 
               class="btn btn-danger btn-sm">
                <i class="fas fa-file-pdf mr-1"></i> Cetak PDF
            </a>

        </div>
    </div>

    {{-- ===== FILTER RT ===== --}}
    <p class="text-muted small mb-2">Filter berdasarkan RT</p>
    <div class="row mb-3" style="row-gap: 10px;">
        @foreach ($rtCounts as $label => $count)
        <div class="col">
            <a href="{{ route('laporan.donasi', ['rt' => ($rt === $label ? null : $label)]) }}"
            class="card text-center shadow-sm h-100 py-2 px-1 text-decoration-none
                    {{ $rt === $label ? 'border-primary bg-light' : 'border' }}">
                <div class="card-body p-1">
                    <p class="text-muted mb-1" style="font-size: 11px;">RT {{ $label }}</p>
                    <h5 class="mb-0 font-weight-bold {{ $rt === $label ? 'text-primary' : 'text-dark' }}">
                        {{ $count }}
                    </h5>
                </div>
            </a>
        </div>
        @endforeach
    </div>

    {{-- Indikator filter aktif --}}
    @if($rt)
        <div class="mb-2">
            <span class="badge badge-primary px-3 py-2" style="font-size: 13px;">
                <i class="fas fa-filter mr-1"></i>
                Menampilkan Laporan RT {{ $rt }}
                <a href="{{ route('laporan.donasi') }}"
                class="ml-2 text-white" style="text-decoration:none;" title="Hapus filter">
                    &times;
                </a>
            </span>
        </div>
    @endif

    {{-- RINGKASAN --}}
    <div class="mb-3">
        <span class="badge badge-primary px-3 py-2">
            Total Donasi: {{ $data->count() }}
        </span>

        <span class="badge badge-success px-3 py-2">
            Total Barang: {{ $data->sum('jumlah') }}
        </span>
    </div>

    {{-- ===== TABEL ===== --}}
    <div class="card shadow mb-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover mb-0" style="font-size: 13.5px;">
                    <thead class="bg-primary text-white text-center">
                        <tr>
                            <th class="align-middle" style="width:45px;">No</th>
                            <th class="align-middle">Nama Donatur</th>
                            <th class="align-middle" style="width:130px;">No Telp</th>
                            <th class="align-middle" style="min-width:180px;">Alamat</th>
                            <th class="align-middle" style="min-width:140px;">Nama Barang</th>
                            <th class="align-middle" style="width:55px;">Jml</th>
                            <th class="align-middle" style="width:90px;">Kondisi</th>
                            <th class="align-middle" style="width:100px;">Tanggal</th>
                            <th class="align-middle" style="width:105px;">Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($data as $item)
                        <tr style="vertical-align: middle;">

                            <td class="text-center text-muted">{{ $loop->iteration }}</td>

                            <td class="font-weight-bold">{{ $item->user->name ?? '-' }}</td>

                            <td class="text-center text-muted" style="font-size:12.5px;">
                                {{ $item->user->no_telp ?? '-' }}
                            </td>

                            <td style="white-space:normal; font-size:12.5px; color:#555;">
                                {{ $item->user->alamat ?? '-' }}
                            </td>

                            <td>{{ $item->nama_barang }}</td>

                            <td class="text-center font-weight-bold">{{ $item->jumlah }}</td>

                            <td class="text-center">{{ $item->kondisi }}</td>

                            <td class="text-center text-muted" style="font-size:12.5px;">
                                {{ \Carbon\Carbon::parse($item->tanggal_pengiriman)->format('d M Y') }}
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
                                @endif
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">
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