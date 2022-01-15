@extends('layouts.app')
@section('content')
    @include('includes.search')
    <div class="table table-responsive" style ="text-align: left">
        <table class="table">
            <thead class="thead-dark">
            <tr>
                <th>{{__('id')}}</th>
                <th>{{__('actions')}}</th>
                <th>{{__('Seller')}}</th>
                <th>{{__('Superior')}}</th>
                <th>{{__('Commission')}}</th>
                <th>{{__('Image')}}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($sellers as $seller)
                <tr id="td_row_{{$seller->id}}">
                    <td> {{$seller->id}} </td>
                    <td>
                        @include('includes.table_actions', ['identity' => $seller->id])
                    </td>
                    <td> {{$seller->getUser()->name}} </td>
                    <td>
                        @if(isset($seller->superior))
                            {{$seller->getSuperior()->name}}
                        @endif
                    </td>
                    <td>
                        {{$seller->commission}}%
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div style="width: 100%;">
        {{ $sellers->links() }}
    </div>
@endsection
