@extends('layouts.app')

@section('header')
    <h1>Holiday Calendar</h1>
    <p></p>
    <a href="{{ route('calendar.create') }}" class = "btn btn-success">Request Holiday</a>
@endsection

@section('body')

    <div class="row">
        <div class="{{ count($pending) > 0 ? 'col-md-4' : 'col-md-12' }}">
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
        <div class="{{ count($holidays_today) > 0 ? 'col-md-8' : 'col-md-12' }}">
            @if(count($pending) > 0)
                <div class="card">
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
                </div>
            @endif
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            @php
                $previous = $current->copy()->subMonth();
                $next = $current->copy()->addMonth();
            @endphp
            <h4>Month View</h4>
            <table class="table table-responsive table-sm">
                <thead class="thead-light">
                <tr>
                    <th>Name</th>
                    @php $iterator = $current->copy(); @endphp
                    @while ($iterator->lt($next))
                        <th class="text-center {{ $iterator->isToday() ? 'alert alert-warning' : ''}}">
                            {{ $iterator->day }}
                        </th>
                         @php $iterator->addDay(); @endphp
                    @endwhile
                </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        @if($user->isSuperAdmin())
                            @continue
                        @endif
                        <tr>
                            <td> {{ str_limit($user->name, 1)}} </td>
                            @php
                                $iterator = $current->copy();
                                $holidays = App\Holiday::getByUser($user);
                            @endphp

                            @while ($iterator->lt($next))
                                @php
                                    $isEmpty = true;
                                @endphp
                                @foreach($holidays as $holiday)
                                    @if($iterator->gte($holiday->start_date->startOfDay()) && $iterator->lte($holiday->end_date->endOfDay()))
                                        @if($holiday->status !== 'denied')
                                            <td class="{{ $holiday->status === 'approved' ? 'alert alert-danger' : 'table-danger' }}" colspan="{{ $holiday->length($iterator) }}"
                                            data-toggle="popover" data-trigger="hover" data-placement="right"
                                            data-original-title="Away for {{ $holiday->length($iterator) }} days"
                                            data-content="The reason given"></td>
                                            @php
                                                $iterator->addDays($holiday->length($iterator));
                                                $isEmpty = false;
                                            @endphp
                                        @endif
                                    @endif
                                @endforeach

                                @if($isEmpty)
                                    <td class="{{ $iterator->isWeekend() ? 'bg-light' : '' }}"></td>
                                    @php $iterator->addDay(); @endphp
                                @endif
                            @endwhile
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('js')

@endsection
