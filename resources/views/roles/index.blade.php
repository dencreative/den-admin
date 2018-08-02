@extends('layouts.app')

@section('header')
    <h1>Roles</h1>
@endsection

@section('body')
    <p>Roles can be assigned different permissions here.</p>
    <table class="table table-sm">
        <thead class="thead-light">
        <tr>
            <th scope="col" rowspan="2">Name</th>
            <th scope="col" class="text-center" colspan="{{ count($permissions) }}">Permissions</th>
            {{--<th scope="col" rowspan="2"></th>--}}
        </tr>
        <tr>
            @foreach($permissions as $permission)
                <th scope="col">{{ $permission->getName() }}</th>
            @endforeach
        </tr>
        </thead>
        <tbody>
        @foreach($roles as $role)
            @if($role->id !== 1)
                <tr>
                    <th scope="row">{{ $role->name }}</th>
                    @foreach($permissions as $permission)
                        <td>
                            @php
                                $hasPermission = $role->hasPermission($permission);
                            @endphp
                            <div class="toggle-switch toggle-switch--red">
                                <input type="checkbox" onclick="togglePermission({{ $role->id }}, {{ $permission->id }}, '{{ route('roles.update', $role->id) }}')" class="toggle-switch__checkbox" {{ $hasPermission ? 'checked': ''}}>
                                <i class="toggle-switch__helper"></i>
                            </div>
                        </td>
                    @endforeach
                    {{--
                   <td class="table-active">
                       <a class="btn btn-primary btn-sm"><i class="zmdi zmdi-eye"></i></a>
                       <a class="btn btn-primary btn-sm"><i class="zmdi zmdi-edit"></i></a>
                       <a class="btn btn-danger btn-sm"><i class="zmdi zmdi-delete"></i></a>
                   </td>
                   --}}
                </tr>
            @endif
        @endforeach
        </tbody>
    </table>
@endsection

@section('footer')
@endsection

@section('js')
    <script>
        function togglePermission(role_id, permission_id, url) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'POST',
                url: url,
                data: { _method: 'PUT', id: role_id, permission_id: permission_id }
            });
        }
    </script>
@endsection