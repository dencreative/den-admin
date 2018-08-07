@extends('layouts.app')

@section('header')
    <h1>Categories</h1>
    <p>Below is the list of categories</p>
    @can('create', App\Playbooks\Category::class)
        <a href="{{ route('categories.create') }}" class = "btn btn-success">Create New Category</a>
    @endcan
@endsection

@section('body')
    @include('layouts.partials.preloader')
    <div class="table-responsive" style="padding: 5px 25px">
        <table id="data-table" class="table">
        <thead class="thead-light">
        <tr>
            <th>Name</th>
            <th></th>
        </tr>
        </thead>
        </table>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $("#data-table").DataTable({
                data: {!! $categories !!}, stateSave: true,
                columns: [
                    { data: "name", searchable: true },
                    { data: "entries", width: "26%", searchable: false, sortable: false,
                        render: function (data, type, row) {
                            var html = '<div class="btn-toolbar justify-content-end" role="toolbar" aria-label="Action Toolbar">' +
                                '<div class="btn-group mr-2" role="group" aria-label="First group">';
                            @can('view', App\Playbooks\Category::class)
                                if(parseInt(data) > 0)
                                    html += '<a href="{{ route('entries.index') }}/' + row.id + '" class="btn btn-primary" >View All (' + data + ')</a>';
                            @endcan
                            @can('update', App\Playbooks\Category::class)
                                html += '<a href="{{ route('categories.index') }}/'+row.id+'/edit" class="btn btn-primary" >Edit</a>';
                            @endcan
                                html += '</div>';
                            @can('delete', App\Playbooks\Category::class)
                                html += '<div class="btn-group mr-2" role="group" aria-label="Second group">';
                                html +=     '<button class="btn btn-danger" onclick="onDelete('+row.id+')">Delete</a>\n';
                                html += '</div>';
                            @endcan
                                html += '</div>';
                            return html;
                        }
                    }
                ],
                autoWidth: false, responsive: true,
                lengthMenu: [[15, 30, 45, -1], ["15 Rows","30 Rows","45 Rows","Everything"]],
                language: { searchPlaceholder: "Search Categories..." }
            });
        });

        function onDelete(id) {
            swal({
                title: 'Delete Category?',
                text: 'Are you sure you want to delete this category? This action cannot be reversed',
                type: 'warning', buttonsStyling: false, confirmButtonClass: 'btn btn-danger', showCancelButton: true, cancelButtonClass: 'btn btn-light',
            }).then((result) => {
                if (result.value) {
                    if (result.value) {
                        $.ajaxSetup({
                            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
                        });
                        $.ajax({
                            type: 'POST',
                            url: '{{ route('categories.index') }}/'+id.toString(),
                            data: { _method: 'DELETE', id: id.toString() }
                        });
                        location.reload();
                    }
                }
            });
        }
    </script>
@endsection

