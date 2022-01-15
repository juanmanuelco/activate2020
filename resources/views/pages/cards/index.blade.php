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
                <th>{{__('Subtitle')}}</th>
                <th>{{__('Price')}}</th>
                <th>{{__('Range')}}</th>
                <th>{{__('Metadata')}}</th>
                <th>{{__('Image')}}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($cards as $card)
                <tr id="td_row_{{$card->id}}">
                    <td> {{$card->id}} </td>
                    <td>
                        @include('includes.table_actions', ['identity' => $card->id])
                    </td>
                    <td> {{$card->name}} </td>
                    <td>
                        {{$card->subtitle}}
                    </td>
                    <td>
                        ${{number_format($card->price, 2, '.',',')}}
                    </td>
                    <td>
                        {{$card->start}} - {{$card->end}}
                    </td>

                    <td>
                        <p>Facebook: <span>{{$card->facebook}}</span></p>
                        <p>Instagram: <span>{{$card->instagram}}</span></p>
                        <p>Days: <span>{{$card->days}}</span></p>
                    </td>
                    <td>
                        @if(!empty($card->getImage()))
                            <img width="100px" src="<?php echo  '/images/system/' . $card->getImage()->id . '.' . $card->getImage()->extension ?>" alt="<?php echo $card->getImage()->name ?>">
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div style="width: 100%;">
        {{ $cards->links() }}
    </div>
@endsection
