@extends('layouts.app')

@section('header')
    <h1>Entries</h1>
    <p>Below is the list of playbook entries</p>
    <a href="{{ route('entries.create') }}" class = "btn btn-success">Create New Entry</a>
@endsection

@section('body')
    @include('layouts.partials.pageloader')

    <div class="table-responsive" style="padding: 5px 25px">
        <table id="data-table" class="table">
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
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $("#data-table").DataTable({
                data: {!! $entries !!}, stateSave: true,
                columns: [
                    { data: "title", width: "15%", searchable: true },
                    { data: "categories", searchable: true,
                        render: function (data) {
                            var html = '';
                            data.forEach(function(element) {
                                html += '<a href="{{ route('categories.index') }}/'+element.id+'" class="btn btn-outline-secondary btn-sm">'+element.name+'</a> ';
                            });
                            return html;
                        }
                    },
                    { data: "created_at", width: "18%", searchable: false },
                    { data: "updated_at", width: "18%", searchable: false },
                    { sortable: false, width : "22%",
                        render: function (data, type, row) {
                                    return '<div class="btn-toolbar" role="toolbar" aria-label="Action Toolbar">\n\n' +
                                                '<div class="btn-group mr-2" role="group" aria-label="First group">'+
                                                    '<a href="{{ route('entries.index') }}/'+row.id+'" class="btn btn-primary">View</a>\n' +
                                                    '<a href="{{ route('entries.index') }}/'+row.id+'/edit"  class="btn btn-primary">Edit</a>\n' +
                                                '</div>'+
                                                '<div class="btn-group mr-2" role="group" aria-label="Second group">'+
                                                '<button class="btn btn-danger" onclick="onDelete('+row.id+')">Delete</a>\n' +
                                                '</div>'+
                                            '</div>';
                                }
                    }
                ],
                autoWidth: false,
                responsive: true,
                lengthMenu: [[15, 30, 45, -1], ["15 Rows","30 Rows","45 Rows","Everything"]],
                language: { searchPlaceholder: "Search Entries..." },
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

