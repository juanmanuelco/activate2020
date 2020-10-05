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
                            <th style="padding-top:25px">
                                <input type="checkbox" id="{{$user->id}}_{{$rol->id}}"  @if($user->hasRole($rol->name)) checked ="true"  @endif>
                            </th>
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
