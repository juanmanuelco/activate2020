@extends('layouts.app')
@section('content')
    @include('includes.form', [
                                    'title' => 'Vendedores',
                                    'description'=> 'de tarjetas',
                                    'route'=> 'seller.store',
                                    'method' => 'POST',
                                    'html'  =>  'pages.sellers.fields',
                                    'object' => null,
                                    'files'     =>  false
                               ])
@endsection
