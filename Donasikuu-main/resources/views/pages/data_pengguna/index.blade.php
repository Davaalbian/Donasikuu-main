@extends('layouts.app')

@section('content')
<div class="container-fluid">

    {{-- JUDUL --}}
    <div class="mb-3">
        <h1 class="h3 mb-1 text-gray-800">Data Pengguna</h1>

        <p class="text-muted small mb-2">
            Kelola data pengguna sistem seperti donatur dan akun terdaftar
        </p>
    </div>

    {{-- BUTTON PDF --}}
    <div class="mb-3">
        <a href="{{ route('data_pengguna.cetak_pdf') }}" target="_blank" class="btn btn-danger btn-sm">
            Cetak PDF
        </a>
    </div>

    {{-- SEARCH --}}
    <div class="mb-3">
        <form method="GET" action="{{ route('data_pengguna.index') }}">
            <div class="input-group" style="max-width: 350px;">
                <input type="text" name="search"
                    class="form-control form-control-sm"
                    placeholder="Cari nama pengguna..."
                    value="{{ request('search') }}">

                <div class="input-group-append">
                    <button class="btn btn-primary btn-sm" type="submit">
                        Cari
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- TABLE --}}
    <div class="card shadow mb-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover mb-0" style="font-size: 13.5px;">
                    <thead class="bg-primary text-white text-center">
                        <tr>
                            <th class="align-middle" style="width:45px;">No</th>
                            <th class="align-middle">Nama</th>
                            <th class="align-middle">Email</th>
                            <th class="align-middle" style="width:130px;">No Telp</th>
                            <th class="align-middle" style="min-width:180px;">Alamat</th>
                            <th class="align-middle" style="width:140px;">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($users as $item)
                        <tr style="vertical-align: middle;">

                            <td class="text-center text-muted">{{ $loop->iteration }}</td>

                            <td class="font-weight-bold">{{ $item->name }}</td>

                            <td class="text-center text-muted" style="font-size:12.5px;">
                                {{ $item->email }}
                            </td>

                            <td class="text-center text-muted" style="font-size:12.5px;">
                                {{ $item->no_telp ?? '-' }}
                            </td>

                            <td style="white-space:normal; font-size:12.5px; color:#555;">
                                {{ $item->alamat ?? '-' }}
                            </td>

                            <td class="text-center">
                                <div class="d-flex justify-content-center align-items-center" style="gap:5px;">

                                    <a href="{{ route('data_pengguna.edit', $item->id) }}"
                                    class="btn btn-sm btn-warning px-3">
                                        Edit
                                    </a>

                                    <form action="{{ route('data_pengguna.destroy', $item->id) }}"
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
                            <td colspan="6" class="text-center text-muted py-4">
                                Belum ada data pengguna
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