@extends('layouts.app')
@section('content')
    @include('includes.search')
    <div class="table table-responsive " >
        <table class="table table-bordered">
            <thead>
            <tr>
                <th></th>
                <th colspan="{{count(\Spatie\Permission\Models\Role::all())}}">{{__('roles')}}</th>
            </tr>
            <tr>
                <th>{{__('Name')}}</th>
                @foreach(\Spatie\Permission\Models\Role::all() as $rol)
                    <th>{{$rol->name}}</th>
                @endforeach
            </tr>
            </thead>
            <tbody>
            @foreach($groups as $group)
                <tr>
                    <td style="text-align: left">
                        <div>{{$group->name}}</div>
                    </td>
                    @foreach(\Spatie\Permission\Models\Role::all() as $rol)
                        <td style=" @if(exists_group_rol($group->id,$rol->id )) background-color: rgba(0,5,50,0.7) @endif" id="td_{{$group->id}}_{{$rol->id}}" class ="td_permission" onclick="markGroupRol('{{$group->id}}_{{$rol->id}}')">
                            <input type="checkbox" onclick="addGroupRol(this)" id="{{$group->id}}_{{$rol->id}}"  @if(exists_group_rol($group->id,$rol->id )) checked ="true"  @endif>
                        </td>
                    @endforeach
                </tr>
            @endforeach
            </tbody>
        </table>
        <div style="width: 100%;">
            {{ $groups->links() }}
        </div>
    </div>
@endsection
