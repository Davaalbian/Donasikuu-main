@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- Judul -->
    <div class="mb-4">
        <h1 class="h3 mb-2 text-gray-800">Dashboard Admin</h1>
        <p class="text-muted">Selamat datang Admin di sistem donasiku!</p>
    </div>

    <!-- Statistik -->
    <div class="row">

        <!-- Total Donasi -->
        <div class="col-md-3 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <h6 class="text-primary">Total Donasi</h6>
                    <h4 class="font-weight-bold">{{ $totalDonasi }}</h4>
                </div>
            </div>
        </div>

        <!-- Pending -->
        <div class="col-md-3 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <h6 class="text-warning">Pending</h6>
                    <h4 class="font-weight-bold">{{ $pending }}</h4>
                </div>
            </div>
        </div>

        <!-- Disetujui -->
        <div class="col-md-3 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <h6 class="text-info">Disetujui</h6>
                    <h4 class="font-weight-bold">{{ $disetujui }}</h4>
                </div>
            </div>
        </div>

        <!-- Disalurkan -->
        <div class="col-md-3 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <h6 class="text-primary">
                        Disalurkan
                    </h6>

                    <h4 class="font-weight-bold">
                        {{ $disalurkan }}
                    </h4>
                </div>
            </div>
        </div>

    </div>

    <!-- Tabel Donasi Terbaru -->
    <div class="card shadow mb-4">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary">Donasi Terbaru</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nama Barang</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($donasiTerbaru as $item)
                            <tr>
                                <td>{{ $item->nama_barang }}</td>
                                <td>{{ $item->jumlah }}</td>
                                <td class="text-start align-middle">
                                    <span class="badge px-3 py-2 text-capitalize
                                        @if($item->status_donasi == 'pending')
                                            bg-warning text-dark
                                        @elseif($item->status_donasi == 'disetujui')
                                            bg-info text-white
                                        @elseif($item->status_donasi == 'disalurkan')
                                            bg-primary text-white
                                        @else
                                            bg-secondary text-white
                                        @endif
                                    ">
                                        {{ $item->status_donasi }}
                                    </span>
                                </td>
                                <td>{{ $item->tanggal_pengiriman }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Belum ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection