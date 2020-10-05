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
                <th>{{__('detail')}}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($permissions as $permission)
                <tr>
                    <td> {{$permission->id}} </td>
                    <td>
                        @include('includes.table_actions', ['identity' => $permission->id])
                    </td>
                    <td> {{$permission->name}} </td>
                    <td>
                        {{$permission->guard_name}}
                    </td>
                    <td>
                        {{$permission->detail}}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div style="width: 100%;">
        {{ $permissions->links() }}
    </div>
@endsection
