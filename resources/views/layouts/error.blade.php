<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- App/Theme styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>


<body data-ma-theme="red">
<section class="error">
    <div class="error__inner">
        @yield('error')
    </div>
</section>

@include('layouts.partials.ie-warning');

<!-- App Scripts-->
<script src="{{ asset('js/app.js') }}" ></script>

</body>
</html>