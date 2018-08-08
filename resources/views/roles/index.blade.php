@extends('layouts.app')

@section('header')
    <h1>Roles</h1>
@endsection

@section('body')

    <div class="card">
        <div class="card-body">
            <table id="table" class="table table-responsive">
                <thead class="thead-light">
                <tr>
                    <th scope="col"></th>
                    @foreach($roles as $role)
                        @if($role->id !== 1)
                            <th scope="col">{{ $role->name }}</th>
                        @endif
                    @endforeach
                </tr>
                </thead>
                <tbody>
                @foreach($permissions as $permission)
                        <tr scope="row">
                            <th> {{ $permission->getName() }}</th>
                            @foreach($roles as $role)
                                @if($role->id !== 1)
                                    <td>
                                        @php
                                            $hasPermission = $role->hasPermission($permission->name) ? 'checked' : '';
                                            $canEdit = Auth::user()->hasPermission('roles_update') ? '' : 'disabled';
                                            $toggleFunction = Auth::user()->hasPermission('roles_update') ? 'togglePermission('.$role->id.', '.$permission->id.')' : '';
                                        @endphp
                                        <div class="toggle-switch toggle-switch--red">
                                            <input type="checkbox" class="toggle-switch__checkbox" onclick="{{$toggleFunction}}" {{ $hasPermission }} {{ $canEdit }}>
                                            <i class="toggle-switch__helper"></i>
                                        </div>
                                    </td>
                                @endif
                            @endforeach
                        </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('footer')

@endsection

@section('js')
    <script>
        function togglePermission(role_id, permission_id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'POST',
                url: 'roles/'+role_id,
                data: { _method: 'PUT', id: role_id, permission_id: permission_id }
            });
        }
    </script>
@endsection