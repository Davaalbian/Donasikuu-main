@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <div class="mb-3">
        <h1 class="h3 mb-1 text-gray-800">Data Donasi</h1>
        <p class="text-muted small mb-0">
            Klik kartu RT untuk memfilter data donasi
        </p>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    {{-- FILTER RT --}}
    <div class="row mb-3" style="row-gap: 10px;">
        @foreach ($rtCounts as $label => $count)
            <div class="col">
                <a href="{{ route('data_donasi.index', array_merge(request()->except('rt', 'page'), ['rt' => ($rt === $label ? null : $label)])) }}"
                   class="card text-center shadow-sm h-100 py-2 px-1 text-decoration-none
                          {{ $rt === $label ? 'border-primary bg-light' : 'border' }}"
                   style="border-radius: 10px; min-width: 85px;">
                    <div class="card-body p-1">
                        <p class="text-muted mb-1" style="font-size: 11px;">{{ $label }}</p>
                        <h5 class="mb-0 font-weight-bold {{ $rt === $label ? 'text-primary' : 'text-dark' }}">
                            {{ $count }}
                        </h5>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

    {{-- FILTER AKTIF --}}
    @if($rt)
        <div class="mb-3">
            <span class="badge badge-primary px-3 py-2 shadow-sm" style="font-size: 13px;">
                <i class="fas fa-filter mr-1"></i>
                Menampilkan Data RT {{ $rt }}

                <a href="{{ route('data_donasi.index', request()->except('rt')) }}"
                class="ml-2 text-white font-weight-bold"
                style="text-decoration:none;">
                    &times;
                </a>
            </span>
        </div>
    @endif

    {{-- SEARCH --}}
    <div class="mb-3">
        <form method="GET" action="{{ route('data_donasi.index') }}">
            @if($rt)
                <input type="hidden" name="rt" value="{{ $rt }}">
            @endif
            <div class="input-group" style="max-width: 350px;">
                <input type="text" name="search" class="form-control form-control-sm"
                    placeholder="Cari nama barang / donatur..."
                    value="{{ request('search') }}">
                <div class="input-group-append">
                    <button class="btn btn-primary btn-sm" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- TABEL --}}
    <div class="card shadow mb-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-bordered mb-0" style="font-size: 13.5px;">
                    <thead class="bg-primary text-white text-center">
                        <tr>
                            <th class="align-middle" style="width:45px;">No</th>
                            <th class="align-middle">Donatur</th>
                            <th class="align-middle" style="width:120px;">No Telp</th>
                            <th class="align-middle" style="min-width:160px;">Alamat</th>
                            <th class="align-middle" style="min-width:140px;">Barang</th>
                            <th class="align-middle" style="width:55px;">Jml</th>
                            <th class="align-middle" style="width:90px;">Kondisi</th>
                            <th class="align-middle" style="width:110px;">Metode</th>
                            <th class="align-middle" style="width:100px;">Tanggal</th>
                            <th class="align-middle" style="width:105px;">Status</th>
                            <th class="align-middle" style="width:65px;">Foto</th>
                            <th class="align-middle" style="width:160px;">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($data_donasi as $item)
                        <tr style="vertical-align: middle;">

                            <td class="text-center text-muted">{{ $loop->iteration }}</td>

                            <td class="font-weight-bold">{{ $item->user->name ?? '-' }}</td>

                            <td class="text-center text-muted" style="font-size:12.5px;">
                                {{ $item->user->no_telp ?? '-' }}
                            </td>

                            <td style="white-space:normal; font-size:12.5px; color:#555; max-width:180px;">
                                {{ $item->user->alamat ?? '-' }}
                            </td>

                            <td>{{ $item->nama_barang }}</td>

                            <td class="text-center font-weight-bold">{{ $item->jumlah }}</td>

                            <td class="text-center">{{ $item->kondisi }}</td>

                            <td class="text-center">{{ $item->metode_pengiriman }}</td>

                            <td class="text-center text-muted" style="font-size:12.5px;">
                                {{ \Carbon\Carbon::parse($item->tanggal_pengiriman)->format('d M Y') }}
                            </td>

                            {{-- STATUS --}}
                            <td class="text-center">
                                @if($item->status_donasi == 'pending')
                                    <span class="badge badge-warning px-2 py-1">Pending</span>

                                @elseif($item->status_donasi == 'disetujui')
                                    <span class="badge badge-info px-2 py-1">Diproses</span>

                                @elseif($item->status_donasi == 'disalurkan')
                                    <span class="badge badge-primary px-2 py-1">Disalurkan</span>

                                @elseif($item->status_donasi == 'ditolak')
                                    <span class="badge badge-danger px-2 py-1">Ditolak</span>

                                @elseif($item->status_donasi == 'selesai')
                                    <span class="badge badge-success px-2 py-1">Selesai</span>
                                @endif
                            </td>

                            {{-- FOTO --}}
                            <td class="text-center">
                                @if($item->foto)
                                    <img src="{{ asset('uploads/donasi/' . $item->foto) }}"
                                        width="46" height="46"
                                        style="object-fit:cover; border-radius:6px; cursor:pointer; border:2px solid #dee2e6;"
                                        onclick="lihatFoto('{{ asset('uploads/donasi/' . $item->foto) }}')">
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>

                            {{-- AKSI --}}
                            <td class="text-center">
                                <div class="d-flex justify-content-center align-items-center flex-wrap" style="gap:5px;">

                                    @if($item->status_donasi == 'pending')
                                        <form action="{{ route('data_donasi.proses', $item->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button class="btn btn-sm btn-info px-3">Proses</button>
                                        </form>

                                        <form action="{{ route('data_donasi.tolak', $item->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button class="btn btn-sm btn-warning px-3">Tolak</button>
                                        </form>
                                    @endif

                                    @if($item->status_donasi != 'disalurkan')
                                        <form action="{{ route('data_donasi.destroy', $item->id) }}"
                                            method="POST" class="form-hapus">
                                            @csrf
                                            @method('DELETE')

                                            <button type="button" class="btn btn-sm btn-danger px-3 btn-hapus">
                                                Hapus
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif

                                </div>
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="12" class="text-center text-muted py-4">
                                Belum ada data donasi
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

{{-- MODAL FOTO --}}
<div class="modal fade" id="modalFoto" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Foto Barang Donasi</h5>
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
function lihatFoto(url) {
    document.getElementById('fotoPreview').src = url;
    $('#modalFoto').modal('show');
}

$(document).on('click', '.btn-hapus', function () {

    let form = $(this).closest('form');

    Swal.fire({
        title: 'Hapus Data?',
        text: 'Data donasi yang dihapus tidak dapat dikembalikan.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal'
    }).then((result) => {

        if (result.isConfirmed) {
            form.submit();
        }

    });

});
</script>
@endpush