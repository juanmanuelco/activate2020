@extends('layouts.app')
@section('content')
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
                           <a href="{{route('groups.show', ['group' => $group->id])}}" class="button_show">  <i class="fa fa-eye"></i> </a>
                           <a href="{{route('groups.edit', ['group' => $group->id])}}" class="button_edit">  <i class="fa fa-edit"></i> </a>
                           <a href="{{route('groups.destroy', ['group' => $group->id])}}" class="button_delete">  <i class="fa fa-trash"></i> </a>
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
