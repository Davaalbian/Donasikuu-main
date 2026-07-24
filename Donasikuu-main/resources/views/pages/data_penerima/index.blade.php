@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <div class="mb-4">
        <h1 class="h3 mb-1 text-gray-800">Data Penerima</h1>
        <p class="text-muted small mb-2">
            Data daftar penerima bantuan yang terdaftar dalam sistem
        </p>

        <a href="{{ route('data_penerima.create') }}" class="btn btn-success btn-sm">
            + Tambah Penerima
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    {{-- TABEL --}}
    <div class="card shadow mb-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover mb-0" style="font-size: 13.5px;">
                    <thead class="bg-primary text-white text-center">
                        <tr>
                            <th class="align-middle" style="width:45px;">No</th>
                            <th class="align-middle">Nama</th>
                            <th class="align-middle" style="width:130px;">No Telp</th>
                            <th class="align-middle" style="min-width:200px;">Alamat</th>
                            <th class="align-middle" style="width:140px;">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($data_penerima as $item)
                        <tr style="vertical-align: middle;">

                            <td class="text-center text-muted">{{ $loop->iteration }}</td>

                            <td class="font-weight-bold">{{ $item->nama }}</td>

                            <td class="text-center text-muted" style="font-size:12.5px;">
                                {{ $item->no_telp ?? '-' }}
                            </td>

                            <td style="white-space:normal; font-size:12.5px; color:#555;">
                                {{ $item->alamat ?? '-' }}
                            </td>

                            <td class="text-center">
                                <div class="d-flex justify-content-center align-items-center" style="gap:5px;">

                                    <a href="{{ route('data_penerima.edit', $item->id) }}"
                                       class="btn btn-sm btn-warning px-3">
                                        Edit
                                    </a>

                                    <form action="{{ route('data_penerima.destroy', $item->id) }}"
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
                            <td colspan="5" class="text-center text-muted py-4">
                                Data penerima tidak tersedia
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>
$(document).on('click', '.btn-hapus', function () {
    let form = $(this).closest('form');
    Swal.fire({
        title: 'Hapus Data?',
        text: 'Data penerima yang dihapus tidak dapat dikembalikan.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) form.submit();
    });
});
</script>
@endpush

@endsection