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
                    <th>{{__('icon')}}</th>
                </tr>
           </thead>
           <tbody>
               @foreach($groups as $group)
                   <tr>
                       <td> {{$group->id}} </td>
                       <td>
                           @include('includes.table_actions', ['identity' => $group->id])
                       </td>
                       <td> {{$group->name}} </td>
                       <td>
                           <i class="{{$group->icon}}" style="font-size: 20px; margin-right: 10px"></i> {{$group->icon}}
                       </td>

                   </tr>
             @endforeach
           </tbody>
       </table>
    </div>
    <div style="width: 100%;">
        {{ $groups->links() }}
    </div>
@endsection
