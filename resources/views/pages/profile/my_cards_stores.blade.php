@extends('layouts.app')
@section('content')
    <?php $no_search = true; ?>

    @include('includes.search')
    <div class="table table-responsive" style ="text-align: left">
        @foreach($stores as $store)
            <div>

                <div class="alert-primary" style="padding:10px">
                    @if(!empty($store->getImage()))
                        <img width="100px" src="<?php echo  '/images/system/' . $store->getImage()->id . '.' . $store->getImage()->extension ?>" alt="{{$store->getImage()->name }}">
                    @endif
                    {{$store->name}}
                </div>

                <div class="flex" style="margin-left: 20px; overflow-y: scroll;  max-height: 650px;">
                    @foreach($store->benefits()->get() as $benefit)
                        <div class="card" style="margin: 10px">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-4">
                                        @if(!empty($benefit->getImage()))
                                            <img width="100%" src="<?php echo  '/images/system/' . $benefit->getImage()->id . '.' . $benefit->getImage()->extension ?>" alt="{{$benefit->getImage()->name }}">
                                        @endif
                                        <div style="text-align: center">
                                            @if($benefit->unlimited)
                                                {{__('Unlimited uses')}}
                                            @else
                                                {{__('Only one use')}}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-8">
                                        <h5>{{__('Benefit')}}</h5>
                                        <div>
                                            {{$benefit->benefit}}
                                        </div>
                                        <hr>
                                        <h5>{{__('Restrictions')}}</h5>
                                        <div>
                                            {{$benefit->restriction}}
                                        </div>
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
        {{ $stores->links() }}
    </div>


@endsection


