<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>@yield('title', 'Donasiku Dashboard')</title>

    <!-- Fonts -->
    <link href="{{ asset('template/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">

    <!-- CSS -->
    <link href="{{ asset('template/css/sb-admin-2.min.css') }}" rel="stylesheet">
</head>

<body id="page-top">

    <div id="wrapper">

        {{-- Sidebar --}}
        @include('layouts.sidebar')

        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">

                {{-- Navbar --}}
                @include('layouts.navbar')

                {{-- Main Content --}}
                <div class="container-fluid">
                    @yield('content')
                </div>

            </div>

            {{-- Footer --}}
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="text-center my-auto">
                        <span>&copy; {{ date('Y') }} Donasiku. Semua hak dilindungi.</span>
                    </div>
                </div>
            </footer>

        </div>

    </div>

    {{-- Scroll to Top --}}
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    {{-- Logout Modal --}}
    <div class="modal fade" id="logoutModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Yakin ingin logout?</h5>
                    <button class="close" data-dismiss="modal">
                        <span>×</span>
                    </button>
                </div>

                <div class="modal-body">
                    Pilih "Logout" jika ingin keluar dari sistem.
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Batal</button>

                    <a class="btn btn-danger" href="#"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                </div>

            </div>
        </div>
    </div>

{{-- FORM LOGOUT WAJIB --}}
<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>

    {{-- JS CORE --}}
    <script src="{{ asset('template/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('template/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('template/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    {{-- TEMPLATE JS --}}
    <script src="{{ asset('template/js/sb-admin-2.min.js') }}"></script>

    {{-- CHART --}}
    <script src="{{ asset('template/vendor/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('template/js/demo/chart-area-demo.js') }}"></script>
    <script src="{{ asset('template/js/demo/chart-pie-demo.js') }}"></script>

    {{-- SWEETALERT --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- 🔥 WAJIB: AGAR @push('scripts') JALAN --}}
    @stack('scripts')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    $(document).on('click', '.btn-hapus', function () {

        let form = $(this).closest('form');

        Swal.fire({
            title: 'Hapus Data?',
            text: 'Data yang dihapus tidak dapat dikembalikan.',
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
</body>
</html>