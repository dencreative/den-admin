@extends('layouts.app')

@section('content')

    <form action="/categories" method="POST">
        @csrf
        @method('POST')

        <div class="card-body" style="z-index: 0;">
            <div class="form-group">
                <input name = "name" type="text" class="form-control form-control-lg" placeholder="New Category Name">
                <i class="form-group__bar"></i>
            </div>
            <button type="submit" class="btn btn-success playbook-button">Create</button>
            <a href="{{ back() }}">
                <button type="button" class="btn btn-light playbook-button">Cancel</button>
            </a>
        </div>
    </form>
@endsection
