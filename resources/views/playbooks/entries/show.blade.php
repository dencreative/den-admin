@extends('layouts.app')

@section('body')
    <div class="card-body">
        <div class="d-flex bd-highlight">
            <div class="mr-auto p-2 bd-highlight">
                <h1 class="display-4">{{ $entry->title }}</h1>
                @foreach($entry->categories as $category)
                    <a href="{{ route('categories.show', $category->id)}}" class="btn btn-outline-secondary btn-sm">{{ $category->name }}</a>
                @endforeach
            </div>
            <div class="p-2 bd-highlight mt-auto">
                <button data-toggle="modal" data-target="#modal-changes" class="btn btn-link">
                    @if($entry->revisions->count() > 0)
                        <i class="zmdi zmdi-edit"> </i>
                        Last edited by {{ $entry->revisions->last()->name }}, {{ $entry->updated_at->diffForHumans() }}
                    @else
                        <i class="zmdi zmdi-file-text"> </i>
                        Created by {{ $entry->creator->name }}, {{ $entry->created_at->diffForHumans() }}
                    @endif
                </button>
            </div>
        </div>
        <hr>

        <p class="lead">{!! $entry->body !!}</p>
    </div>
@endsection

@section('footer')
    <div class="playbook-button card-footer">
        <a href="{{ route('entries.index') }}">
            <button type="button" class="btn btn-light playbook-button">Back</button>
        </a>
    </div>
@endsection

@section('modal')
    <div class="modal fade" id="modal-changes" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title pull-left">All Changes</h5>
                </div>
                <div class="modal-body">
                    <?php $j = 0 ?>
                    <?php $revisions = $entry->revisions->sortByDesc(function ($user) { return $user->pivot->updated_at; }); ?>
                        <div class="accordion" role="tablist">
                            @foreach($revisions as $user)
                            <div class="card">
                                <div class="card-header" role="tab" id="heading{{$j++}}">
                                    <a data-toggle="collapse" href="#collapse{{$j}}" aria-expanded="false" aria-controls="collapse{{$j}}">
                                        {{ $user->pivot->updated_at->diffForHumans() }} by {{ $user->name }}
                                    </a>
                                </div>
                                <div id="collapse{{$j}}" class="collapse" style="padding-top:5px" role="tabpanel" aria-labelledby="heading{{$j}}" data-parent="#accordion">
                                    <div class="card-body">
                                        <table class="table table-sm">
                                            <thead>
                                            <tr>
                                                <th scope="col" style="width: 6%"> </th>
                                                <th scope="col" style="width: 47%" class="text-danger">Before</th>
                                                <th scope="col" style="width: 47%" class="text-success">After</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $before = json_decode($user->pivot->before, true); ?>
                                            <?php $after = json_decode($user->pivot->after, true); ?>
                                            @for ($i = 0; $i < count($before); $i++)
                                                <tr>
                                                    <th scope="row">{!!  ucwords(array_keys($before)[$i]) !!}</th>
                                                    <td>{!! array_values($before)[$i] !!}</td>
                                                    <td>{!! array_values($after)[$i] !!}</td>
                                                </tr>
                                            @endfor
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                                <div class="card">
                                    <div class="card-header">
                                        <a><i class="zmdi zmdi-file-text"> </i> Created by {{ $entry->creator->name }}, {{ $entry->created_at->diffForHumans() }}</a>
                                    </div>
                                </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection
