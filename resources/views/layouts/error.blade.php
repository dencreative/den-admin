<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Vendor styles -->
    <link rel="stylesheet" href="vendors/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="vendors/bower_components/animate.css/animate.min.css">
    <link rel="stylesheet" href="vendors/bower_components/jquery.scrollbar/jquery.scrollbar.css">

    <!-- App/Theme styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/theme.css') }}" rel="stylesheet">
</head>


<body data-ma-theme="red">
<section class="error">
    <div class="error__inner">
        @yield('error')
    </div>
</section>

@include('layouts.partials.ie-warning');

<!-- Javascript -->

<!-- Vendors Scripts -->
<script src="../vendors/bower_components/jquery/dist/jquery.min.js"></script>
<script src="../vendors/bower_components/popper.js/dist/umd/popper.min.js" ></script>
<script src="../vendors/bower_components/bootstrap/dist/js/bootstrap.min.js" ></script>
<script src="../vendors/bower_components/jquery.scrollbar/jquery.scrollbar.min.js" ></script>
<script src="../vendors/bower_components/jquery-scrollLock/jquery-scrollLock.min.js" ></script>

<!-- App Scripts-->
<script src="{{ asset('js/app.js') }}" ></script>
<script src="{{ asset('js/theme.min.js') }}" ></script>

</body>
</html>