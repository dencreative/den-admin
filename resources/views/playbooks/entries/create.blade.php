@extends('layouts.app')

@section('body')
    <form action="{{ route('entries.index') }}" method="POST">
        @csrf
        @method('POST')

        <div class="card-body" style="z-index: 0;">
            
            <div class="form-group">
                <input name = "title" type="text" class="form-control form-control-lg" placeholder="New Title">
                <i class="form-group__bar"></i>
            </div>

            <div class="form-group">
                <select class="categories-select" multiple="multiple" name="categories[]" style="width: 100%;">
                    @foreach($categories as $category)
                        <option value="{{ $category->name }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <textarea name ="body" class="trumbowyg-box" placeholder="New body content..."></textarea>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-success playbook-button">Create</button>
                <a href="{{ route('entries.index') }}">
                    <button type="button" class="btn btn-light playbook-button">Cancel</button>
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
                placeholder: "Select or Create Categories",
                tokenSeparators: [','],
                tags: true
            });
        });
    </script>
@endsection
