@extends('layouts.playbook-layout')

@section('header')
    <div class="d-flex bd-highlight">
        <div class="mr-auto p-2 bd-highlight">
            <h1>Categories: {{$category->name}}</h1>
            <p>Below is the list of entries in {{$category->name}}</p>
        </div>

        <div class="p-2 bd-highlight my-auto">
            <a href="/categories/" class = "btn btn-outline-dark btn-lg">Show All</a>
        </div>
    </div>
@endsection

@section('content')
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
@endsection

@section('js')
    <script>
        $(document).ready(function()
        {
            $(".category-entries-data-table").DataTable(
                {
                    data: {!! $entries !!},
                    stateSave: true,
                    columns: [
                        {
                            data: "title",
                            width: "15%",
                            searchable: true
                        },
                        {
                            data: "categories",
                            searchable: true,
                            render: function (data)
                            {
                                var html = '';
                                data.forEach(function(element) {
                                    var active = {{ $category->id }} == element.id ? 'active no-pointer-events' : '';
                                    html += '<a href="/categories/'+element.id+'"class="btn btn-outline-secondary btn-sm '+active+'">'+element.name+'</a> ';
                                });
                                return html;
                            }
                        },
                        {
                            data: "created_at",
                            width: "18%",
                            searchable: false
                        },
                        {
                            data: "updated_at",
                            width: "18%",
                            searchable: false
                        },
                        {
                            "sortable": false,
                            "width" : "22%",
                            render: function (data, type, row)
                            {
                                return '<div class="btn-toolbar" role="toolbar" aria-label="Action Toolbar">\n\n' +
                                    '<div class="btn-group mr-2" role="group" aria-label="First group">'+
                                    '<a href="/entries/'+row.id+'" class="btn btn-primary">View</a>\n' +
                                    '<a href="/entries/'+row.id+'/edit" class="btn btn-primary">Edit</a>\n' +
                                    '</div>'+
                                    '<div class="btn-group mr-2" role="group" aria-label="Second group">'+
                                    '<button class="btn btn-danger" onclick="onDelete('+row.id+')">Delete</a>\n' +
                                    '</div>'+
                                    '</div>';
                            }
                        }
                    ],
                    autoWidth: !1,
                    responsive: !0,
                    lengthMenu: [[15, 30, 45, -1], [
                        "15 Rows",
                        "30 Rows",
                        "45 Rows",
                        "Everything"
                    ]],
                    language: { searchPlaceholder: "Search Entries in {{$category->name}}..." }
                });
        });

        function onDelete(id) {
            swal({
                title: 'Delete Entry?',
                text: 'Are you sure you want to delete this entry? This action cannot be reversed',
                type: 'warning',
                buttonsStyling: false,
                confirmButtonClass: 'btn btn-danger',
                showCancelButton: true,
                cancelButtonClass: 'btn btn-light',
            }).then((result) => {
                if (result.value) {
                    var form = document.createElement("form");
                    document.body.appendChild(form);
                    form.method = 'POST';
                    form.action = '/entries/'+id.toString();
                    var element1 = document.createElement("INPUT");
                    element1.name='_token';
                    element1.value = '{{ csrf_token() }}';
                    element1.type = 'hidden';
                    form.appendChild(element1);
                    var element2 = document.createElement("INPUT");
                    element2.name='_method';
                    element2.value = 'DELETE';
                    element2.type = 'hidden';
                    form.appendChild(element2);
                    form.submit();
                }
            });
        }
    </script>
@endsection

