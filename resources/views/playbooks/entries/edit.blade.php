@extends('layouts.app')

@section('body')
    <form action="{{ route('entries.index') }}/{{ $entry->id }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card-body" style="z-index: 0;">

            <div class="form-group">
                <input name = "title" type="text" class="form-control form-control-lg" value="{!! $entry->title !!}">
                <i class="form-group__bar"></i>
            </div>

            <div class="form-group">
                <select class="categories-select" multiple="multiple" name="categories[]" style="width: 100%; z-index:20;">
                    @foreach($categories_selected as $category)
                        <option value="{{ $category->name }}" selected>{{ $category->name }}</option>
                    @endforeach
                    @foreach($categories_remaining as $category)
                        <option value="{{ $category->name }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <textarea name = "body" class = "trumbowyg-box" data-id="{!! $entry->id !!}">
                    {!! $entry->body !!}
                </textarea>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-success playbook-button">Save</button>
                <a href="{{ route('entries.index') }}">
                    <button type="button" class="btn btn-light playbook-button">Back</button>
                </a>
            </div>
        </div>

    </form>

@endsection

@section('js')
    
    <script>
        $('.trumbowyg-box').trumbowyg({
            svgPath:'/assets/icons/wysiwyg.svg'
        });

        $(document).ready(function() {
            $('.categories-select').select2({
                placeholder: "Select Categories",
                tokenSeparators: [','],
                tags: true
            });
        });
    </script>
@endsection