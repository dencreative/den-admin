@extends('layouts.app')

@section('header')

    <div class="d-flex bd-highlight">
        <div class="mr-auto p-2 bd-highlight">
            <h1>Categories</h1>
            <p>Below is the list of categories</p>
        </div>
        <div class="p-2 bd-highlight my-auto">
            <a href="/categories/create" class = "btn btn-success btn-lg">Create New Category</a>
        </div>
    </div>

@endsection

@section('content')

    <div class="table-responsive" style="padding: 5px 25px">
        <table id="data-table" class="categories-data-table table">
        <thead class="thead-light">
        <tr>
            <th>Name</th>
            <th> </th>
        </tr>
        </thead>
        </table>
    </div>

@endsection

@section('js')

    <script>
        $(document).ready(function() {
            $(".categories-data-table").DataTable(
            {
                data: {!! $categories !!},
                stateSave: true,
                columns: [
                    { data: "name", searchable: true },
                    { data: "entries", width: "25%",
                        render: function (data, type, row)
                        {
                            var hasEntries = parseInt(data) > 0;
                            var viewAll = '';
                            if(hasEntries)
                                viewAll = '<a href="/categories/'+row.id+'" class="btn btn-primary">View All ('+data+')</a>';
                            return  '<div class="btn-toolbar" role="toolbar" aria-label="Action Toolbar">\n\n' +
                                        '<div class="btn-group mr-2 ml-auto" role="group" aria-label="First group">'+
                                     viewAll+
                                        '<a href="/categories/'+row.id+'/edit" class="btn btn-primary">Edit</a>\n' +
                                    '</div>'+
                                    '<div class="btn-group ml-auto" role="group" aria-label="Second group">'+
                                    '<button class="btn btn-danger" onclick="onDelete('+row.id+')">Delete</a>\n' +
                                        '</div>'+
                                    '</div>';
                        }
                    }
                ],
                autoWidth: !1,
                responsive: !0,
                lengthMenu: [[15, 30, 45, -1], [ "15 Rows", "30 Rows", "45 Rows", "Everything" ]],
                language: { searchPlaceholder: "Search Categories..." }
            });
        });

        function onDelete(id) {
            swal({
                title: 'Delete Category?',
                text: 'Are you sure you want to delete this category? This action cannot be reversed',
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
                    form.action = '/categories/'+id.toString();
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

