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
                @foreach($users as $user)
                    <tr>
                        <td style="text-align: left">
                            <div>{{$user->name}}</div>
                            <div><small>{{$user->email}}</small></div>
                        </td>
                        @foreach(\Spatie\Permission\Models\Role::all() as $rol)
                            <td style="@if($user->hasRole($rol->name))  background-color: rgba(0,5,50,0.7) @endif" id="td_{{$user->id}}_{{$rol->id}}" class ="td_permission" onclick="markRol('{{$user->id}}_{{$rol->id}}')">
                                <input type="checkbox" onclick="addRol(this)" id="{{$user->id}}_{{$rol->id}}"  @if($user->hasRole($rol->name)) checked ="true"  @endif>
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div style="width: 100%;">
            {{ $users->links() }}
        </div>
    </div>
@endsection
