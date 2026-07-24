<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Donasiku Auth')</title>

    <!-- Custom fonts -->
    <link href="{{ asset('template/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,400,700" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <!-- Custom styles -->
    <link href="{{ asset('template/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <style>
    body {
        background: linear-gradient(135deg, #F0F4FF, #DBEAFE);
        min-height: 100vh;
    }

    .card {
        border-radius: 16px;
        background: #F8FAFF;
        box-shadow: 0 20px 60px rgba(37,99,235,0.13);
        border: 1px solid rgba(15,23,42,0.09);
    }

    .form-control:focus {
        box-shadow: 0 0 0 3px rgba(37,99,235,0.2);
        border-color: #2563EB;
    }

    .btn-primary {
        background: linear-gradient(135deg, #2563EB, #0EA5E9);
        border: none;
        border-radius: 8px;
    }
</style>
</head>

<body>

    <div class="container min-vh-100 d-flex align-items-center justify-content-center">
        <div class="row justify-content-center w-100">
            <div class="col-lg-5 col-md-8 col-12">

                @yield('content')

            </div>
        </div>

    </div>

    <!-- Scripts -->
    <script src="{{ asset('template/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('template/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('template/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('template/js/sb-admin-2.min.js') }}"></script>

</body>

</html>