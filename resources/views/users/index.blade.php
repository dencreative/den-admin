@extends('layouts.app')


@section('header')
    <h1>Users</h1>
@endsection

@section('body')
    @include('layouts.partials.pageloader')

    <table id="user-table" class="table">
        <thead class="thead-light">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Roles</th>
            <th scope="col">Date Created</th>
            <th scope="col"></th>
        </tr>
        </thead>
    </table>
@endsection

@section('footer')
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $("#user-table").DataTable(
                {
                    data: {!! $users !!},
                    stateSave: true,
                    columns: [
                        { data: "id", width : "7.5%", searchable: true },
                        { data: "name", width : "15%", searchable: true },
                        { data: "roles", searchable: true,
                            render: function (data, type, row) {
                                @php
                                    $canEdit = Auth::user()->hasPermission('roles_assign') ? '' : 'disabled';
                                @endphp
                                var html = '<select class="select2" multiple {{$canEdit}} data-placeholder="Select roles">';
                                @json($roles).forEach(function(element) {
                                    var userID = ' data-user="'+row.id+'"';
                                    var roleID = ' data-role="'+element['id']+'"';
                                    var isSelected = data.includes(element['id'])  ? ' selected':'';
                                    html += '<option'+userID + roleID + isSelected+'>'+element['name']+'</option>';
                                });
                                return html+'</select>';
                            }
                        },
                        { data: "created_at", width: "15%", searchable: false },
                        { sortable: false, width : "15%",
                            render: function (data, type, row)
                            {
                                return '<div class="btn-toolbar" role="toolbar" aria-label="Action Toolbar">' +
                                    '<div class="btn-group mr-2" role="group" aria-label="First group">'+
                                        '<a href="/users/'+row.id+'" class="btn btn-primary btn-sm"><i class="zmdi zmdi-account"></i></a>' +
                                        '<a href="/users/'+row.id+'/edit" class="btn btn-primary btn-sm"><i class="zmdi zmdi-edit"></i></a>' +
                                    '</div>'+
                                    '<div class="btn-group mr-2" role="group" aria-label="Second group">'+
                                        '<button class="btn btn-danger btn-sm" onclick="onDelete('+row.id+')"><i class="zmdi zmdi-delete"></i></a>' +
                                    '</div>'+
                                '</div>';
                            }
                        }
                    ],
                    autoWidth: false,
                    responsive: true,
                    lengthMenu: [[15, 30, 45, -1], ["15 Rows","30 Rows","45 Rows","Everything" ]],
                    language: { searchPlaceholder: "Search Users..." }
                });

            $('.select2').select2();
            $('.select2').on('select2:select', function (e) {
                var element = e.params.data.element;
                toggleRole($(element).data('user'), $(element).data('role'), $(element).data('url'));
            });
            $('.select2').on('select2:unselect', function (e) {
                var element = e.params.data.element;
                toggleRole($(element).data('user'), $(element).data('role'), $(element).data('url'));
            });

            function toggleRole(user_id, role_id, url) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'POST',
                    url: 'users/'+user_id,
                    data: { _method: 'PUT', id: user_id, role_id: role_id }
                });
            }
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

