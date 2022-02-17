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
                <th>{{__('Owner')}}</th>
                <th>{{__('Description')}}</th>
                <th>{{__('Metadata')}}</th>
                <th>{{__('Image')}}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($stores as $store)
                <tr id="td_row_{{$store->id}}">
                    <td> {{$store->id}} </td>
                    <td>
                        @include('includes.table_actions', ['identity' => $store->id])
                    </td>
                    <td> {{$store->name}} </td>
                    <td>
                        {{$store->owner() != null ? $store->owner()->name : __('Not set')}}
                    </td>
                    <td>
                        {{$store->description}}
                    </td>

                    <td>
                        <p>Facebook: <span>{{$store->facebook}}</span></p>
                        <p>Instagram: <span>{{$store->instagram}}</span></p>
                        <p>Phone: <span><a href="tel:{{$store->phone}}">{{$store->phone}}</a></span></p>
                        <p>Web page: <span><a href="{{$store->web_page}}">{{$store->web_page}}</a></span></p>
                    </td>
                    <td>
                        @if(!empty($store->getImage()))
                            <img width="100px" src="<?php echo  '/images/system/' . $store->getImage()->id . '.' . $store->getImage()->extension ?>" alt="<?php echo $store->getImage()->name ?>">
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div style="width: 100%;">
        {{ $stores->links() }}
    </div>
@endsection
