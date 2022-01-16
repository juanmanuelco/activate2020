@extends('layouts.app')
@section('content')
    <?php $no_search = true; ?>
    @include('includes.search')
    <?php $all_qr = []; ?>
    <div class="table table-responsive" style ="text-align: left">
        @foreach($cards as $card)
            <div>

                <div class="alert-primary" style="padding:10px">
                    @if(!empty($card->getImage()))
                        <img width="100px" src="<?php echo  '/images/system/' . $card->getImage()->id . '.' . $card->getImage()->extension ?>" alt="<?php echo $card->getImage()->name ?>">
                    @endif
                    {{$card->name}}
                </div>

                <div class="flex" style=" overflow-y: scroll; max-height: 550px">
                    <?php
                        $assignments = $card->assignments()->where('email', auth()->user()->email)->get() ;?>
                    @foreach( $assignments as $assignment)
                        <?php array_push($all_qr, ['id' => $assignment->id, 'code'=>$assignment->code]) ?>
                       <div class="card" style="margin: 5px">
                           <div class="card-body">
                               <div class="row">
                                   <div class="col-3">
                                       <div style="text-align: center" id="qr_{{$assignment->id}}">

                                       </div>
                                   </div>
                                   <div class="col-9">
                                       <p>
                                           {{__('Number')}} : {{$assignment->number}}
                                       </p>
                                       <p>
                                           {{__('Valid between')}} :
                                           <small>
                                               {{$assignment->start}}  {{'  -  '}} {{$assignment->end}}
                                           </small>
                                       </p>
                                       <button class="btn btn-outline-primary btn-block" onclick="location.replace(location.origin + '/my-cards/' + {{$assignment->id}})">{{__('Show benefits')}}</button>
                                   </div>
                               </div>


                           </div>
                       </div>

                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
    <div style="width: 100%;">
        {{ $cards->links() }}
    </div>


@endsection


@section('new_scripts')
    <script src="{{asset('js/qrcode.js')}}"></script>
    <script>
        @foreach($all_qr as $key=> $qr)
            new QRCode(document.getElementById("qr_{{$qr['id']}}"), {
                text : "{{$qr['code']}}",
                width: 100,height: 100,
                correctLevel : QRCode.CorrectLevel.H
            });
        @endforeach
    </script>

@endsection

