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
                <th>{{__('Card')}}</th>
                <th>{{__('Image')}}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($markets as $market)
                <tr id="td_row_{{$market->id}}">
                    <td> {{$market->id}} </td>
                    <td>
                        @include('includes.table_actions', ['identity' => $market->id])
                    </td>
                    <td> {{$market->name}} </td>
                    <td>
                        {{$market->card()->name}}
                    </td>
                    <td>
                        @if(!empty($market->getImage()))
                            <img width="100px" src="<?php echo  '/images/system/' . $market->getImage()->id . '.' . $market->getImage()->extension ?>" alt="{{$market->getImage()->name}}">
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div style="width: 100%;">
        {{ $markets->links() }}
    </div>
@endsection
