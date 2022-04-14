@extends('layouts.app')
@section('content')
    @include('includes.search')
    <div class="table table-responsive" style ="text-align: left">
        <table class="table">
            <thead class="thead-dark">
            <tr>
                <th>{{__('id')}}</th>
                <th>{{__('actions')}}</th>
                <th>{{__('Quantity')}}</th>
                <th>{{__('Name')}}</th>
                <th>{{__('Description')}}</th>
                <th>{{__('Code')}}</th>
                <th>{{__('Price')}}</th>
                <th>{{__('Image')}}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($products as $product)
                <tr id="td_row_{{$product->id}}">
                    <td> {{$product->id}} </td>
                    <td>
                        @include('includes.table_actions', ['identity' => $product->id])
                    </td>
                    <td> {{$product->quantity}} </td>
                    <td> {{$product->name}} </td>
                    <td>
                        {!! $product->description !!}
                    </td>
                    <td>
                        {{$product->code}}
                    </td>
                    <td>
                        ${{$product->price}}
                    </td>
                    <td>
                        @if(!empty($product->getImage()))
                            <img width="100px" src="<?php echo $product->getImage()->permalink ?>" alt="<?php echo $product->getImage()->name ?>">
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div style="width: 100%;">
        {{ $products->links() }}
    </div>
@endsection
