@extends('layouts.app')
@section('content')
    @include('includes.show', [
                                    'title' => 'Vendedores',
                                    'description'=> 'de tarjetas',
                                    'html'  =>  'pages.sellers.fields_readonly',
                                    'object' => $seller,
                               ])
@endsection
