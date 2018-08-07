@if (count($errors))
    <div class = "alert alert-warning row" style="margin: 10px 0px;">
        <div class="col-md-8">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    </div>
@endif