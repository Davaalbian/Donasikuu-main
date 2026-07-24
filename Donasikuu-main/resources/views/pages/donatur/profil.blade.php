{{-- resources/views/pages/donatur/profil.blade.php --}}

@extends('layouts.donatur')

@section('title', 'Profil Saya')

@section('content')
<div class="container-fluid">

    <!-- Judul Halaman -->
    <div class="mb-4">
        <h1 class="h3 mb-2 text-gray-800">Profil Saya</h1>
        <p class="text-muted">Kelola informasi akun dan keamanan Anda.</p>
    </div>

    <div class="row">

        <!-- Kartu Info Profil (Kiri) -->
        <div class="col-xl-4 col-lg-5 mb-4">
            <div class="card shadow">
                <div class="card-body text-center py-5">
                    <!-- Avatar -->
                    <div class="mb-3">
                        <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center"
                            style="width:90px; height:90px;">
                            <span class="text-white font-weight-bold" style="font-size:2rem;">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </span>
                        </div>
                    </div>

                    <h5 class="font-weight-bold text-gray-800 mb-1">{{ Auth::user()->name }}</h5>
                    <p class="text-muted small mb-3">{{ Auth::user()->email }}</p>

                    <span class="badge badge-primary px-3 py-2">
                         Donatur
                    </span>

                    <hr class="my-4">

                    <div class="text-left">
                        <p class="text-xs text-uppercase text-muted font-weight-bold mb-2">Informasi Akun</p>
                        <p class="mb-2 small">
                            <i class="fas fa-user fa-fw text-gray-400 mr-2"></i>
                            {{ Auth::user()->name }}
                        </p>
                        <p class="mb-2 small">
                            <i class="fas fa-envelope fa-fw text-gray-400 mr-2"></i>
                            {{ Auth::user()->email }}
                        </p>
                        <p class="mb-2 small">
                            <i class="fas fa-phone fa-fw text-gray-400 mr-2"></i>
                            {{ Auth::user()->no_telp ?? '-' }}
                        </p>
                        <p class="mb-2 small">
                            <i class="fas fa-venus-mars fa-fw text-gray-400 mr-2"></i>
                            {{ Auth::user()->jenis_kelamin == 'L' ? 'Laki-laki' : (Auth::user()->jenis_kelamin == 'P' ? 'Perempuan' : '-') }}
                        </p>
                        <p class="mb-2 small">
                            <i class="fas fa-map-marker-alt fa-fw text-gray-400 mr-2"></i>
                            {{ Auth::user()->alamat ?? '-' }}
                        </p>
                        <p class="mb-0 small">
                            <i class="fas fa-calendar-alt fa-fw text-gray-400 mr-2"></i>
                            Bergabung {{ Auth::user()->created_at->format('d M Y') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Edit Profil (Kanan) -->
        <div class="col-xl-8 col-lg-7 mb-4">

            <!-- Card: Ubah Data Diri -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-user-edit mr-2"></i>Ubah Data Diri
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('donatur.profil.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Nama -->
                        <div class="form-group">
                            <label for="name" class="font-weight-bold text-gray-700 small">
                                Nama Lengkap <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light">
                                        <i class="fas fa-user text-gray-400"></i>
                                    </span>
                                </div>
                                <input type="text"
                                    class="form-control @error('name') is-invalid @enderror"
                                    id="name"
                                    name="name"
                                    value="{{ old('name', Auth::user()->name) }}"
                                    placeholder="Masukkan nama lengkap"
                                    required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="form-group">
                            <label for="email" class="font-weight-bold text-gray-700 small">
                                Alamat Email <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light">
                                        <i class="fas fa-envelope text-gray-400"></i>
                                    </span>
                                </div>
                                <input type="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    id="email"
                                    name="email"
                                    value="{{ old('email', Auth::user()->email) }}"
                                    placeholder="Masukkan email"
                                    required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- No. Telepon -->
                        <div class="form-group">
                            <label for="no_telp" class="font-weight-bold text-gray-700 small">
                                No. Telepon
                            </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light">
                                        <i class="fas fa-phone text-gray-400"></i>
                                    </span>
                                </div>
                                <input type="text"
                                    class="form-control @error('no_telp') is-invalid @enderror"
                                    id="no_telp"
                                    name="no_telp"
                                    value="{{ old('no_telp', Auth::user()->no_telp) }}"
                                    placeholder="Contoh: 08123456789"
                                    maxlength="15"
                                    pattern="[0-9]+"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                @error('no_telp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Jenis Kelamin -->
                        <div class="form-group">
                            <label for="jenis_kelamin" class="font-weight-bold text-gray-700 small">
                                Jenis Kelamin
                            </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light">
                                        <i class="fas fa-venus-mars text-gray-400"></i>
                                    </span>
                                </div>
                                <select class="form-control @error('jenis_kelamin') is-invalid @enderror"
                                    id="jenis_kelamin"
                                    name="jenis_kelamin">
                                    <option value="">-- Pilih Jenis Kelamin --</option>
                                    <option value="L"
                                        {{ old('jenis_kelamin', Auth::user()->jenis_kelamin) == 'L' ? 'selected' : '' }}>
                                        Laki-laki
                                    </option>
                                    <option value="P"
                                        {{ old('jenis_kelamin', Auth::user()->jenis_kelamin) == 'P' ? 'selected' : '' }}>
                                        Perempuan
                                    </option>
                                </select>
                                @error('jenis_kelamin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="rt" class="font-weight-bold text-gray-700 small">
                                RT
                            </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light">
                                        <i class="fas fa-map-marker-alt text-gray-400"></i>
                                    </span>
                                </div>

                                <select name="rt" id="rt"
                                    class="form-control @error('rt') is-invalid @enderror">
                                    <option value="">-- Pilih RT --</option>
                                    @for ($i = 1; $i <= 6; $i++)
                                        @php $val = str_pad($i, 2, '0', STR_PAD_LEFT) @endphp
                                        <option value="{{ $val }}" {{ old('rt', $user->rt) == $val ? 'selected' : '' }}>
                                            RT {{ $val }}
                                        </option>
                                    @endfor
                                </select>

                                @error('rt')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Alamat -->
                        <div class="form-group">
                            <label for="alamat" class="font-weight-bold text-gray-700 small">
                                Alamat
                            </label>

                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light">
                                        <i class="fas fa-map-marker-alt text-gray-400"></i>
                                    </span>
                                </div>

                                <textarea class="form-control @error('alamat') is-invalid @enderror"
                                    id="alamat"
                                    name="alamat"
                                    rows="3"
                                    placeholder="Masukkan alamat lengkap">{{ old('alamat', Auth::user()->alamat) }}</textarea>
                            </div>

                            <!-- helper text rapi & aman -->
                            <span style="font-size: 12px; color: #858796; display: block; margin-top: 4px;">
                                Contoh: Gg. Gama RT 02/03 Pinang, Kota Tangerang.
                            </span>

                            @error('alamat')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">

                        <!-- Ganti Password -->
                        <p class="font-weight-bold text-gray-700 small mb-3">
                            <i class="fas fa-lock mr-1 text-gray-400"></i>
                            Ganti Password <span class="text-muted font-weight-normal">(opsional — kosongkan jika tidak ingin ganti)</span>
                        </p>

                        <!-- Password Lama -->
                        <div class="form-group">
                            <label for="current_password" class="font-weight-bold text-gray-700 small">
                                Password Saat Ini
                            </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light">
                                        <i class="fas fa-key text-gray-400"></i>
                                    </span>
                                </div>
                                <input type="password"
                                    class="form-control @error('current_password') is-invalid @enderror"
                                    id="current_password"
                                    name="current_password"
                                    placeholder="Masukkan password saat ini">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('current_password', this)">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                @error('current_password')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Password Baru -->
                        <div class="form-group">
                            <label for="password" class="font-weight-bold text-gray-700 small">
                                Password Baru
                            </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light">
                                        <i class="fas fa-lock text-gray-400"></i>
                                    </span>
                                </div>
                                <input type="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    id="password"
                                    name="password"
                                    placeholder="Minimal 8 karakter">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password', this)">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Konfirmasi Password -->
                        <div class="form-group">
                            <label for="password_confirmation" class="font-weight-bold text-gray-700 small">
                                Konfirmasi Password Baru
                            </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light">
                                        <i class="fas fa-lock text-gray-400"></i>
                                    </span>
                                </div>
                                <input type="password"
                                    class="form-control"
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    placeholder="Ulangi password baru">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password_confirmation', this)">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-3">
                            <a href="{{ route('donatur.dashboard') }}" class="btn btn-secondary mr-2">
                                <i class="fas fa-times mr-1"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-1"></i> Simpan Perubahan
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    function togglePassword(fieldId, btn) {
        const input = document.getElementById(fieldId);
        const icon = btn.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }
</script>
@endpush

{{-- SWEETALERT --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- ERROR POPUP --}}
@if ($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            icon: 'error',
            title: 'Terjadi Kesalahan!',
            html: `{!! implode('<br>', $errors->all()) !!}`,
            confirmButtonColor: '#e74a3b'
        });

        // Fokus ke input error pertama
        setTimeout(() => {
            let firstError = document.querySelector('.is-invalid');
            if (firstError) {
                firstError.focus();
            }
        }, 300);
    });
</script>
@endif

{{-- SUCCESS POPUP --}}
@if (session('status') == 'profile-updated')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "Profil berhasil diperbarui",
            confirmButtonColor: '#1cc88a'
        });
    });
</script>
@endif