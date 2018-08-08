@extends('layouts.app')

@section('header')
    <div class="d-flex bd-highlight">
        <div class="mr-auto p-2 bd-highlight">
            <h1>Holiday Calendar</h1>
            <p></p>
        </div>
        <div class="pc-2 bd-highlight my-auto">
            <a href="/holidays/create" class = "btn btn-success btn-lg">Request Holiday</a>
        </div>
    </div>
@endsection

@section('body')
    <div class="card">
        <div class="card-body">
            @php
                $previous = $current->copy()->subMonth();
                $next = $current->copy()->addMonth();
            @endphp

            <div class="d-flex bd-highlight" style="padding-top: 10px">
                <div class="ml-4 my-auto mr-auto p-2 bd-highlight">
                    <a href="/holidays/{{$previous->year }}/{{ $previous->month }}" class = "btn btn-outline-primary">Previous</a>
                </div>
                <div class="mx-auto p-2 bd-highlight">
                    <a href="" class = "btn btn-primary btn-lg">{{ $current->format('F') }}</a>
                    <a href="" class = "btn btn-primary btn-lg">{{ $current->format('Y') }}</a>
                </div>
                <div class="mr-4 my-auto ml-auto p-2 bd-highlight">
                    <a href="/holidays/{{$next->year }}/{{ $next->month }}" class = "btn btn-outline-primary">Next</a>
                </div>
            </div>
            <div style="padding: 5px 25px; margin-left: 200px">
                <div class="table-responsive">
                    <table class="table">
                        <thead class="thead-light">
                        <tr>
                            <th class="name-col-fixed">Name</th>
                            @php $iterator = $current->copy() @endphp
                            @while ($iterator->lt($next))
                                <th class = "holiday-row {{ $iterator->isWeekend() ? 'weekend-col' : '' }}">
                                    {{ $iterator->day }} <br>
                                    <small>{{ $iterator->format('D') }}</small>
                                </th>

                                 @php $iterator->addDay(); @endphp
                            @endwhile
                        </tr>
                        </thead>
                        {{--@foreach($users as $user)--}}
                            {{--<tr>--}}
                                {{--<td class="holiday-row name-col-fixed"> {{ str_limit($user->name, 20)}} </td>--}}
                                {{--@php--}}
                                    {{--$iterator = $current->copy();--}}
                                    {{--$calendar = $user->calendar($current->year, $current->month);--}}
                                {{--@endphp--}}
                                {{--@while ($iterator->lt($next))--}}
                                    {{--@php( $status =  )--}}
                                    {{--@if(isset($calendar[$iterator->day]))--}}

                                    {{--@else--}}
                                        {{--<th class=""></th>--}}
                                    {{--@endif--}}
                                    {{--@php $iterator->addDay(); @endphp--}}
                                {{--@endwhile--}}
                            {{--</tr>--}}
                        {{--@endforeach--}}
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')

@endsection
