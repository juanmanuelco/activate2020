@extends('layouts.app')
@section('content')
    @include('includes.search')
            <div class="table table-responsive" style ="text-align: left">
        <table class="table">
            <thead class="thead-dark">
            <tr>
                <th>{{__('ID')}}</th>
                <th>{{__('actions')}}</th>
                <th>{{__('Name')}}</th>
                <th>{{__('Email')}}</th>
                <th>{{__('Code Phone')}}</th>
                <th>{{__('Phone')}}</th>
                <th>{{__('Point')}}</th>
                <th>{{__('Gains')}}</th>
                <th>{{__('Birthday')}}</th>
                <th>{{__('Gender')}}</th>
                <th>{{__('Roles')}}</th>
            </tr>
            </thead>
            <tbody>
             @foreach($users as $user)
                <tr id="td_row_{{$user->id}}">
                    <td> {{$user->id}} </td>
                    <td>
                        @include('includes.table_actions', ['identity' => $user->id])
                    </td>
                    <td> {{$user->name}} </td>
                    <td> {{$user->email}} </td>
                    <td> {{$user->code_phone}} </td>
                    <td> {{$user->phone}} </td>
                    <td> {{$user->points}} </td>
                    <td> ${{$user->gains}} </td>
                    <td> {{$user->birthday}} </td>
                    <td> {{$user->gender}} </td>
                    <td>
                        @if(count($user->getRoleNames()) == 0)
                            <div>
                                Cliente
                            </div>
                        @endif
                        @foreach($user->getRoleNames() as $role)
                            <div>
                                {{$role}}
                            </div>
                        @endforeach
                    </td>
                </tr>
                  @endforeach
            </tbody>
        </table>
    </div>
    <div style="width: 100%;">
        {{ $users->links() }}
    </div>
      @endsection
