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
    <link rel="stylesheet" href="{{ url('vendors/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.css') }}">
    <link rel="stylesheet" href="{{ url('vendors/bower_components/animate.css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ url('vendors/bower_components/jquery.scrollbar/jquery.scrollbar.css') }}">
    <link rel="stylesheet" href="{{ url('vendors/bower_components/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ url('vendors/bower_components/trumbowyg/dist/ui/trumbowyg.min.css') }}">
    <link rel="stylesheet" href="{{ url('vendors/bower_components/sweetalert2/dist/sweetalert2.min.css') }}">
{{--    <link rel="stylesheet" href="{{ url('vendors/bower_components/datatables.net-buttons-dt/css/buttons.dataTables.min.css') }}">--}}

    <!-- App/Theme styles -->
    <link href="{{ asset('css/theme.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body data-ma-theme="red">
<main class="main">

    @include('layouts.partials.header')

    @include('layouts.partials.sidebar')

    <section class="content">
        <header class="content__title">
            @yield('header')
        </header>

        <div class="card">
            <div class="card-body">
                @yield('body')
            </div>
            <div class="card-footer">
                @yield('footer')
            </div>
        </div>

        @yield('modal')

        @include('layouts.partials.footer')

    </section>
</main>

@include('layouts.partials.ie-warning');

<!-- App Scripts-->
<script src="{{ asset('js/app.js') }}" ></script>

<!-- Vendors Scripts -->
<script src="{{ url('vendors/bower_components/popper.js/dist/umd/popper.min.js') }}" ></script>
<script src="{{ url('vendors/bower_components/bootstrap/dist/js/bootstrap.min.js') }}" ></script>
<script src="{{ url('vendors/bower_components/jquery.scrollbar/jquery.scrollbar.min.js') }}" ></script>
<script src="{{ url('vendors/bower_components/jquery-scrollLock/jquery-scrollLock.min.js') }}" ></script>

<script src="{{ url('vendors/bower_components/select2/dist/js/select2.full.min.js') }}" ></script>
<script src="{{ url('vendors/bower_components/datatables.net/js/jquery.dataTables.min.js') }}" ></script>
{{--<script src="{{ url('vendors/bower_components/datatables.net-buttons/js/dataTables.buttons.min.js') }}" ></script>--}}
<script src="{{ url('vendors/bower_components/trumbowyg/dist/trumbowyg.min.js') }}"></script>
<script src="{{ url('vendors/bower_components/sweetalert2/dist/sweetalert2.min.js') }}"></script>

<!-- Theme Scripts-->
<script src="{{ asset('js/theme.min.js') }}" ></script>

@yield('js')

</body>
</html>