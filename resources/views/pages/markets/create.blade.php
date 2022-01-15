@extends('layouts.app')
@section('content')
    @include('includes.form', [
                                    'title' => 'Imagenes para marketplace',
                                    'description'=> 'Imagenes con descripción de tarjeta',
                                    'route'=> 'market.store',
                                    'method' => 'POST',
                                    'html'  =>  'pages.markets.fields',
                                    'object' => null,
                                    'files'     =>  false
                               ])
@endsection
