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
                <th>{{__('Slug')}}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($builders as $builder)
                <tr>
                    <td> {{$builder->id}} </td>
                    <td>
                        @include('includes.table_actions', ['identity' => $builder->id])
                    </td>
                    <td> {{$builder->name}} </td>
                    <td>
                        <a href="{{route('page_name', ['page'=>$builder->slug])}}" target="_blank">{{$builder->slug}}</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div style="width: 100%;">
        {{ $builders->links() }}
    </div>
@endsection
