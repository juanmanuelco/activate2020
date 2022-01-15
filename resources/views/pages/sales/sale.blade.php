@extends('layouts.app')
@section('content')
    @include('includes.form', [
                                    'title' => 'Generar venta',
                                    'description'=> 'de tarjeta de beneficios',
                                    'route'=> 'sale.store',
                                    'method' => 'POST',
                                    'html'  =>  'pages.sales.fields',
                                    'object' => null,
                                    'files'     =>  false
                               ])
@endsection
