@extends('layouts.app')
@section('content')
    <?php $no_search = true; ?>

    @include('includes.search')
    <button class="btn btn-primary" onclick="ExportToExcel('xlsx')">Export to excel</button>

    <div class="table table-responsive" style ="text-align: left" id="report_sheet">
        <table class="table">
            <tr>
                <th>{{__('Sales date')}}</th>
                <th>{{__('Image')}}</th>
                <th>{{__('Card')}}</th>
                <th>{{__('Card price')}}</th>
                <th>{{__('Card number')}}</th>
                <th>{{__('Customer')}}</th>
                <th>{{__('Payments')}}</th>
            </tr>

            @foreach($cards as $card)
                <tr>
                    <td>{{$card->sale_date}}</td>
                    <td>
                        @if(!empty($card->getCard()->getImage()))
                            <img width="100px" src="<?php echo  '/images/system/' . $card->getCard()->getImage()->id . '.' . $card->getCard()->getImage()->extension ?>" alt="{{$card->getCard()->getImage()->name}}">
                        @endif
                    </td>
                    <td>
                        {{$card->getCard()->name}}
                    </td>
                    <td>
                        $ {{number_format($card->getCard()->price, 2,'.', ',')}}
                    </td>
                    <td>
                        {{$card->number}}
                    </td>
                    <td>
                        {{$card->email}}
                    </td>
                    <td>
                        @php
                            use Spatie\Permission\Models\Role;
                            $roles = auth()->user()->getRoleNames()->toArray();
                            $roles = Role::query()->whereIn('name', $roles)->where('is_admin', true)->first();

                            @endphp
                        @foreach($card->getPayments() as $payment)
                            @if(
	                            !empty($roles) ||
	                            $payment->getSeller()->user == auth()->user()->id ||
	                            $payment->getSeller()->superior == auth()->user()->id
	                            )
                            <div class="row">
                                <div class="col-8">
                                    <div class="form-group">
                                        <strong>{{$payment->getSeller()->name}}</strong>
                                        <p>
                                            <small>{{__('Value to pay')}}: ${{number_format($payment->payment,2,'.',',')}}</small>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-4" id="is_payed_{{$payment->id}}">
                                    @if($payment->paid)
                                        {{__('Paid by ')}} {{$payment->payer()->name}}
                                    @elseif($payment->getSeller()->user == auth()->user()->id )
                                        {{__('Waiting pay')}}
                                    @else
                                        <button type="button" onclick="pay_sale({{$payment->id}})" class="btn btn-outline-primary">{{__('Pay')}}</button>
                                    @endif
                                </div>
                            </div>
                            @endif
                        @endforeach
                    </td>
                </tr>
            @endforeach

        </table>
    </div>
    <div style="width: 100%;">
        {{ $cards->links() }}
    </div>

    <div id="elementH"></div>

@endsection

@section('new_scripts')
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
    <script src="{{ asset('js/jspdf.js') }}"></script>
@endsection


