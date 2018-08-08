@extends('layouts.app')

@section('body')
    <div class="card">
        <div class="card-body">
            <form action="/holidays" method="POST">
                @csrf
                @method('POST')

                <div class="card-body" style="z-index: 0;">

                    <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="zmdi zmdi-calendar"> </i></span>
                        </div>
                        <input type="text" class="form-control date-picker" placeholder="Pick a date">
                    </div>

                    <button type="submit" class="btn btn-primary playbook-button">Request</button>
                    <a href="/holidays">
                        <button type="button" class="btn btn-light playbook-button">Cancel</button>
                    </a>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $(".date-picker").flatpickr({
                mode: "range",
            });
        });
    </script>
@endsection


