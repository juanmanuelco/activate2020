@extends('layouts.app')
@section('content')
    @include('includes.search')
    <div class="table table-responsive" style ="text-align: left">
        <table class="table">
            <thead class="thead-dark">
            <tr>
                <th>{{__('Date')}}</th>
                <th>{{__('Detail')}}</th>
                <th>{{__('Subtotal')}}</th>
                <th>{{__('Discount')}}</th>
                <th>{{__('Total')}}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($billings as $billing)
                <tr id="td_row_{{$billing->id}}">
                    <td> {{$billing->created_at}} </td>
                    <td>
                       <ul>
                           @foreach($billing->details as $product)
                            <li>{{ $product->quantity }} {{$product->name}}</li>
                           @endforeach
                       </ul>
                    </td>
                    <td> ${{ number_format($billing->subtotal, 2, '.', ',') }} </td>
                    <td>
                        ${{ number_format($billing->discount, 2, '.', ',') }}
                    </td>
                    <td>
                        ${{number_format($billing->total, 2, '.', ',') }}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div style="width: 100%;">
        {{ $billings->links() }}
    </div>
@endsection
