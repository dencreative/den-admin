@extends('layouts.app')

@section('body')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('categories.index') }}" method="POST">
                @csrf
                @method('POST')

                <div class="card-body" style="z-index: 0;">
                    <div class="form-group">
                        <input name = "name" type="text" class="form-control form-control-lg" placeholder="New Category Name">
                        <i class="form-group__bar"></i>
                    </div>
                    <button type="submit" class="btn btn-success playbook-button">Create</button>
                    <a href="{{ route('categories.index') }}">
                        <button type="button" class="btn btn-light playbook-button">Cancel</button>
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
