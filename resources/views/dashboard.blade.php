@extends('layouts.app')

@section('header')
    <h1>Dashboard</h1>
@endsection

@section('body')
    <div class="jumbotron">
        <h1 class="display-3"> {{ $greeting }}, {{ Auth::user()->name }}</h1>
        <p class="lead">This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.</p>
        <hr class="my-4">

        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
    </div>
@endsection

@section('footer')
@endsection
