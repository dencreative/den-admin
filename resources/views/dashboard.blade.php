@extends('layouts.app')

@section('header')
    <h1>Dashboard</h1>
@endsection

@section('body')
    <div class="card">
        <div class="card-body">
            <div class="jumbotron">
                <h1 class="display-3"> {{ $greeting }}, {{ Auth::user()->name }}</h1>
                <p class="lead">This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.</p>
                <hr class="my-4">

                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                {{--<canvas id="myChart"></canvas>--}}
            </div>
        </div>
    </div>
@endsection

{{--@section('js')--}}
    {{--<script>--}}
        {{--var ctx = document.getElementById('myChart').getContext('2d');--}}
        {{--var myDoughnutChart = new Chart(ctx, {--}}
            {{--type: 'doughnut',--}}
            {{--data: {--}}
                {{--labels: ["Me", "You", "They", "April", "May"],--}}
                {{--datasets: [{--}}
                    {{--// label: "My First dataset",--}}
                    {{--backgroundColor: 'rgb(255, 99, 132)',--}}
                    {{--borderColor: 'rgb(255, 99, 132)',--}}
                    {{--data: [20, 30, 40, 1, 17],--}}
            {{--}]--}}
        {{--},--}}
        {{--// Configuration options go here--}}
        {{--options: {}--}}
        {{--});--}}
    {{--</script>--}}
{{--@endsection--}}
