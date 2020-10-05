@extends('layouts.app')
@section('content')
    @include('includes.search')
    <div class="table table-responsive" style ="text-align: left">
        <table class="table">
            <thead class="thead-dark">
            <tr>
                <th>{{__('id')}}</th>
                <th>{{__('actions')}}</th>
                <th>{{__('Name')}}</th>
                <th>{{__('guard')}}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($roles as $role)
                <tr>
                    <td> {{$role->id}} </td>
                    <td>
                        @include('includes.table_actions', ['identity' => $role->id])
                    </td>
                    <td> {{$role->name}} </td>
                    <td>
                       {{$role->guard_name}}
                    </td>

                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div style="width: 100%;">
        {{ $roles->links() }}
    </div>
@endsection
