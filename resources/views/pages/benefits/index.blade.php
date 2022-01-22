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
                <th>{{__('Benefit')}}</th>
                <th>{{__('Restriction')}}</th>
                <th>{{__('Store')}}</th>
                <th>{{__('Image')}}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($benefits as $benefit)
                <tr id="td_row_{{$benefit->id}}">
                    <td> {{$benefit->id}} </td>
                    <td>
                        @include('includes.table_actions', ['identity' => $benefit->id])
                    </td>
                    <td>
                        {{$benefit->name}}
                        <p>
                            <span class="small">
                                @if($benefit->unlimited)
                                    {{__('Unlimited uses')}}
                                @else
                                    {{__('Only one use')}}
                                @endif
                            </span>
                        </p>
                    </td>
                    <td>
                        {!! $benefit->benefit !!}
                    </td>
                    <td>
                        {!! $benefit->restriction !!}
                    </td>
                    <td>
                        {{$benefit->store()->first()->name }}
                    </td>
                    <td>
                        @if(!empty($benefit->getImage()))
                            <img width="100px" src="<?php echo  '/images/system/' . $benefit->getImage()->id . '.' . $benefit->getImage()->extension ?>" alt="<?php echo $benefit->getImage()->name ?>">
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div style="width: 100%;">
        {{ $benefits->links() }}
    </div>
@endsection
