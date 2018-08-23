<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- App styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body data-ma-theme="red">
<main class="main">

    @include('layouts.partials.header')

    @include('layouts.partials.sidebar')

    <section class="content">
        @hasSection('header')
            <header class="content__title">
                @yield('header')
            </header>
        @endif

            @include('layouts.partials.errors')

            @yield('body')

            @yield('modal')

            @include('layouts.partials.footer')
    </section>
</main>

@include('layouts.partials.ie-warning');


<!-- App Scripts-->
<script src="{{ asset('js/app.js') }}" ></script>

@yield('js')

</body>
</html>