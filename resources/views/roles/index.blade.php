@extends('layouts.app')

@section('header')
    <h1>Roles</h1>
@endsection

@section('body')

    <table id="table" class="table table-responsive">
        <thead class="thead-light">
        <tr>
            <th scope="col"Name</th>
            @foreach($permissions as $permission)
                <th scope="col">{{ $permission->getName() }}</th>
            @endforeach
        </tr>
        </thead>
        <tbody>
        @foreach($roles as $role)
            @if($role->id !== 1)
                <tr scope="row">
                    <th> {{ $role->name }}</th>
                    @foreach($permissions as $permission)
                        <td>
                            @php
                                $hasPermission = $role->hasPermission($permission->name) ? 'checked' : '';
                                $canEdit = Auth::user()->hasPermission('roles_update') ? '' : 'disabled';
                                $toggleFunction = Auth::user()->hasPermission('roles_update') ? 'togglePermission('.$role->id.', '.$permission->id.', "'.route('roles.update', $role->id).'")' : '';
                            @endphp
                            <div class="toggle-switch toggle-switch--red">
                                <input type="checkbox" class="toggle-switch__checkbox" onclick="{{$toggleFunction}}" {{ $hasPermission }} {{ $canEdit }}>
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