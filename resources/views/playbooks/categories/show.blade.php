@extends('layouts.app')

@section('header')
    <h1>Categories: {{$category->name}}</h1>
    <p>Below is the list of entries in {{$category->name}}</p>
    <a href="{{ route('categories.index') }}" class = "btn btn-outline-dark">Show All</a>
@endsection

@section('body')
    @include('layouts.partials.preloader')
    <div class="card">
        <div class="card-body">
            <div class="table-responsive" style="padding: 5px 25px">
                <table id="data-table" class="table category-entries-data-table">
                    <thead class="thead-light">
                    <tr>
                        <th>Title</th>
                        <th>Categories</th>
                        <th>Date Created</th>
                        <th>Last Modified</th>
                        <th></th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function()
        {
            $("#data-table").DataTable(
                {
                    data: {!! $entries !!}, stateSave: true,
                    columns: [
                        { data: "title", width: "15%", searchable: true },
                        { data: "categories", searchable: true,
                            render: function (data) {
                                var html = '';
                                data.forEach(function(element) {
                                    var active = {{ $category->id }} == element.id ? 'active no-pointer-events' : '';
                                    html += '<a href="{{ route('categories.index') }}/'+element.id+'"class="btn btn-outline-secondary btn-sm '+active+'">'+element.name+'</a> ';
                                });
                                return html;
                            }
                        },
                        { data: "created_at", width: "18%", searchable: false },
                        { data: "updated_at", width: "18%", searchable: false },
                        { "sortable": false, "width" : "22%",
                            render: function (data, type, row) {
                                return '<div class="btn-toolbar" role="toolbar" aria-label="Action Toolbar">\n\n' +
                                    '<div class="btn-group mr-2" role="group" aria-label="First group">'+
                                    '<a href="{{ route('entries.index') }}/'+row.id+'" class="btn btn-primary">View</a>\n' +
                                    '<a href="{{ route('entries.index') }}/'+row.id+'/edit" class="btn btn-primary">Edit</a>\n' +
                                    '</div>'+
                                    '<div class="btn-group mr-2" role="group" aria-label="Second group">'+
                                    '<button class="btn btn-danger" onclick="onDelete('+row.id+')">Delete</a>\n' +
                                    '</div>'+
                                    '</div>';
                            }
                        }
                    ],
                    autoWidth: false, responsive: true,
                    lengthMenu: [[15, 30, 45, -1], [ "15 Rows", "30 Rows", "45 Rows", "Everything" ]],
                    language: { searchPlaceholder: "Search Entries in {{$category->name}}..." }
                });
        });

        function onDelete(id) {
            swal({
                title: 'Delete Entry?',
                text: 'Are you sure you want to delete this entry? This action cannot be reversed',
                type: 'warning', buttonsStyling: false, confirmButtonClass: 'btn btn-danger', showCancelButton: true, cancelButtonClass: 'btn btn-light',
            }).then((result) => {
                if (result.value) {
                    $.ajaxSetup({
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
                    });
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('entries.index') }}/'+id.toString(),
                        data: { _method: 'DELETE', id: id.toString() }
                    });
                    location.reload();
                }
            });
        }
    </script>
@endsection

