{{-- resources/views/pages/donatur/dashboard.blade.php --}}

@extends('layouts.donatur')

@section('title', 'Dashboard Donatur')

@section('content')
<div class="container-fluid">

    <!-- Judul -->
    <div class="mb-4">
        <h1 class="h3 mb-2 text-gray-800">Dashboard Donatur</h1>
        <p class="text-muted">Selamat datang, <strong>{{ Auth::user()->name }}</strong>! Berikut ringkasan donasi Anda.</p>
    </div>

    <!-- Statistik Cards -->
    <div class="row">

        <!-- Total Donasi Saya -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Donasi Saya</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalDonasi }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pending</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pending }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Disetujui -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Disetujui</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $disetujui }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Selesai -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Selesai</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $selesai }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Tabel Donasi Terbaru -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Donasi Terbaru Saya</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th>Jumlah</th>
                            <th>Kondisi</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($donasiTerbaru as $i => $item)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $item->nama_barang }}</td>
                                <td>{{ $item->jumlah }}</td>
                                <td>{{ $item->kondisi }}</td>
                                <td>{{ $item->tanggal_pengiriman }}</td>
                                <td class="text-center align-middle">
                                    @if($item->status_donasi == 'pending')
                                        <span class="badge bg-warning text-dark px-3 py-2">Pending</span>

                                    @elseif($item->status_donasi == 'disetujui')
                                        <span class="badge bg-info text-white px-3 py-2">Diproses</span>

                                    @elseif($item->status_donasi == 'disalurkan')
                                        <span class="badge bg-primary text-white px-3 py-2">Disalurkan</span>

                                    @elseif($item->status_donasi == 'selesai')
                                        <span class="badge bg-success text-white px-3 py-2">Selesai</span>

                                    @elseif($item->status_donasi == 'ditolak')
                                        <span class="badge bg-danger text-white px-3 py-2">Ditolak</span>

                                    @else
                                        <span class="badge bg-secondary text-white px-3 py-2">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Belum ada donasi</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection