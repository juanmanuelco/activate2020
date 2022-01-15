@extends('layouts.app')
@section('content')
    @include('includes.form', [
                                    'title' => 'Vendedores',
                                    'description'=> 'de tarjetas',
                                    'route'=> 'seller.update',
                                    'method' => 'PUT',
                                    'html'  =>  'pages.sellers.fields',
                                    'object' => $seller,
                                    'files'     =>  false
                               ])
@endsection
