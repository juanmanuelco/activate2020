@extends('layouts.app')
@section('content')
    @include('includes.search')
    <div class="table table-responsive" style ="text-align: left">
        @foreach($cards as $card)
            <div>

                <div class="alert-primary" style="padding:10px">
                    @if(!empty($card->getImage()))
                        <img width="100px" src="<?php echo  '/images/system/' . $card->getImage()->id . '.' . $card->getImage()->extension ?>" alt="<?php echo $card->getImage()->name ?>">
                    @endif
                    {{$card->name}}
                </div>

                <div class="flex" style="margin-left: 20px; overflow-y: scroll; max-height: 550px">
                    @foreach($card->assignments()->get() as $assignment)
                        @if(in_array($assignment->seller, $seller_ids))
                        <div class="card" style="margin: 5px">
                            <div class="card-body">
                                <p>
                                    <strong>{{__('Number')}} :</strong> <small>{{$assignment->number}}</small>
                                </p>
                                <p>
                                    <strong>{{__('Assigned to')}} :</strong> <small id="assigned_to_{{$assignment->id}}">{{$assignment->getSeller()->name}}</small>
                                </p>

                                @if(count($sellers) > 1)
                                    <small><strong>{{__('Change assignment')}}</strong></small>
                                <div class="form-group">
                                    <select name="" id="select_assignated_{{$assignment->id}}" class="form-control">
                                        @foreach($sellers as $key => $seller)
                                            <option value="{{$key}}" {{$key == $assignment->seller ? 'selected': ''}}>{{$seller}}</option>
                                        @endforeach
                                    </select>

                                </div>
                                <div class="form-group" style="float: right">
                                    <button class="btn btn-outline-primary" onclick="change_assignment('{{$assignment->id}}')">{{__('Save')}}</button>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
    <div style="width: 100%;">
        {{ $cards->links() }}
    </div>
@endsection
