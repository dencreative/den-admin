@extends('layouts.app')

@section('header')
    <h1>Holiday Calendar</h1>
    <p></p>
    <a href="/holidays/create" class = "btn btn-success btn-lg">Request Holiday</a>
@endsection

@section('body')

    <div class="row">
        <div class="col-md-4">
            @if(count($holidays_today) > 0)
                <div class="card">
                    <div class="card-body">
                        <span class="toolbar__label">{{ count($holidays_today) }} {{count($holidays_today) == 1 ? 'Person' : 'People'}} Away Today</span>
                        <small class="justify-content-end">({{ count($upcoming) }} Upcoming Holiday{{count($upcoming) == 1 ? '' : 's'}})</small>
                        <hr>
                        <div class="row ml-0">
                            @foreach($holidays_today as $holiday)
                                <i class="avatar-img avatar-char bg-red mr-1"
                                   data-toggle="popover" data-trigger="hover" data-placement="right"
                                   data-original-title="{{ $holiday->user->name }}"
                                   data-content="{{ $holiday->returnDate() }}">
                                    {{ $holiday->user->name[0] }}
                                </i>
                            @endforeach

                            @foreach($upcoming as $holiday)
                                <i class="avatar-img avatar-char bg-blue-grey mr-1"
                                   data-toggle="popover" data-trigger="hover" data-placement="right"
                                   data-original-title="{{ $holiday->user->name }}"
                                   data-content="{{ $holiday->start_date->diffForHumans() }} for {{ $holiday->length() }} days">
                                    {{ $holiday->user->name[0] }}
                                </i>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <div class="col-md-8">
            <div class="card">
                @if(count($pending) > 0)
                    <div class="toolbar toolbar--inner">
                        <div class="toolbar__label">{{ count($pending) }} Upcoming Holiday Request{{count($pending) > 1 ? 's' : ''}}</div>
                    </div>

                    <div class="listview listview--bordered">
                        @foreach($pending as $holiday)
                            <div class="listview__item">
                                <i class="listview__img avatar-img avatar-char bg-blue-grey">{{ $holiday->user->name[0] }}</i>

                                <div class="listview__content">
                                    <div class="listview__heading">{{ $holiday->user->name }} has requested a holiday</div>
                                    <p> From {{ $holiday->start_date->format('l jS F') }} to {{ $holiday->end_date->format('l jS F') }}</p>
                                    <div class="listview__attrs">
                                        <span>Days Requested: {{ $holiday->workingLength() }}</span>
                                        <span>Days Left: XX</span>
                                    </div>
                                </div>
                                <div class="actions listview__actions">
                                    <a><i class="actions__item zmdi zmdi-check text-success"></i></a>
                                    <a><i class="actions__item zmdi zmdi-close text-danger"></i></a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">

            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            @php
                $previous = $current->copy()->subMonth();
                $next = $current->copy()->addMonth();
            @endphp
            <h4>Month View</h4>

            {{--<div>--}}
                <div class="table-responsive">
                    <table class="table table-fixed-head-col">
                        <thead class="thead-light">
                        <tr>
                            <th class="fixed-head-col">Name</th>
                            @php $iterator = $current->copy(); @endphp
                            @while ($iterator->lt($next))
                                <th class = "text-center">
                                    {{ $iterator->day }} <br>
                                    <small>{{ $iterator->format('D') }}</small>
                                </th>

                                 @php $iterator->addDay(); @endphp
                            @endwhile
                        </tr>
                        </thead>
                        @foreach($users as $user)
                            <tr>
                                <td class="fixed-head-col"> {{ str_limit($user->name, 20)}} </td>
                                @php
                                    $iterator = $current->copy();
                                    $holidays = $user->holidays($current->year, $current->month);
                                @endphp
                                @while ($iterator->lt($next))
                                    @if(isset($holidays[$iterator->day]))
                                        <th class="alert alert-danger"
                                            data-toggle="popover" data-trigger="hover" data-placement="bottom"
                                            data-original-title="Holiday from here to there"
                                            data-content="The reason given"></th>
                                    @else
                                        <th></th>
                                    @endif
                                    @php $iterator->addDay(); @endphp
                                @endwhile
                            </tr>
                        @endforeach
                    </table>
                </div>
            {{--</div>--}}
        </div>
    </div>
@endsection

@section('js')

@endsection
