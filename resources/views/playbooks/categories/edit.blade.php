@extends('layouts.playbook-layout')

@section('content')

    <form action="/categories/{!!$category->id!!}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body" style="z-index: 0;">
            <div class="form-group">
                <input name = "name" type="text" class="form-control form-control-lg" value="{!! $category->name !!}"></input>
                <i class="form-group__bar"></i>
            </div>

            <button type="submit" class="btn btn-success playbook-button">Save</button>
            <a href="/categories">
                <button type="button" class="btn btn-light playbook-button">Cancel</button>
            </a>
        </div>

    </form>

@endsection