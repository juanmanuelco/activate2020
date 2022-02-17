@extends('layouts.app')
@section('content')
    <?php $no_search = true; ?>

    @include('includes.search')
    <div class="table table-responsive" style ="text-align: left">
        @foreach($cards as $card)
            <div>

                <div class="alert-primary" style="padding:10px">
                    @if(!empty($card->getImage()))
                        <img width="100px" src="<?php echo  '/images/system/' . $card->getImage()->id . '.' . $card->getImage()->extension ?>" alt="<?php echo $card->getImage()->name ?>">
                    @endif
                    {{$card->name}} [ ${{number_format($card->price, 2,'.', ',')}} ]
                </div>

                <div class="flex" style="margin-left: 20px; overflow-y: scroll;  max-height: 650px;">
                    @foreach($card->assignments()->get() as $assignment)
                        @if(empty($assignment->email) && $assignment->getSeller()->user == auth()->user()->id)
                            <div class="card" style="margin: 5px">
                                <div class="card-body">
                                    <p>
                                        <small>{{__('Number')}} :</small> <strong style="font-size: 150%">{{$assignment->number}}</strong>
                                    </p>
                                    <p>
                                        <button type="button" onclick="modal_sell({{$assignment->id}})" class="btn btn-outline-primary btn-lg btn-block">{{__('Sell')}}</button>
                                    </p>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
    <div style="width: 100%;">
        @if($cards != [])
            {{ $cards->links() }}
        @endif
    </div>


@endsection


