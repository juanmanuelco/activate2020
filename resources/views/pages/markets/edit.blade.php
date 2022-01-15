@extends('layouts.app')
@section('content')
    @include('includes.form', [
                                    'title' => 'Imagenes para marketplace',
                                    'description'=> 'Imagenes con descripción de tarjeta',
                                    'route'=> 'market.update',
                                    'method' => 'PUT',
                                    'html'  =>  'pages.markets.fields',
                                    'object' => $market,
                                    'files'     =>  false
                               ])
@endsection
