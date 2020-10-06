@extends('layouts.app')
@section('content')
    @include('includes.search')
    <div class="table table-responsive " >
        <table class="table table-bordered">
            <thead>
            <tr>
                <th ></th>
                <th colspan="{{count(\Spatie\Permission\Models\Role::all())}}">{{__('roles')}}</th>
            </tr>
            <tr>
                <th >{{__('permissions')}}</th>
                @foreach(\Spatie\Permission\Models\Role::all() as $rol)
                    <th>{{$rol->name}}</th>
                @endforeach
            </tr>
            </thead>
            <tbody>
            @foreach($permissions as $permission)
                <tr>
                    <td style="text-align: left">
                        <div>{{$permission->name}}</div>
                        <div><small>{{$permission->detail}}</small></div>
                    </td>
                    @foreach(\Spatie\Permission\Models\Role::all() as $rol)
                        <td style="padding-top:25px; @if($rol->hasPermissionTo($permission->name)) background-color: rgba(0,5,50,0.7) @endif" id="td_{{$permission->id}}_{{$rol->id}}" class ="td_permission" onclick="markPermission('{{$permission->id}}_{{$rol->id}}')">
                            <input type="checkbox" onclick="addPermission(this)" id="{{$permission->id}}_{{$rol->id}}"  @if($rol->hasPermissionTo($permission->name)) checked ="true"  @endif>
                        </td>
                    @endforeach
                </tr>
            @endforeach
            </tbody>
        </table>
        <div style="width: 100%;">
            {{ $permissions->links() }}
        </div>
    </div>

@endsection
