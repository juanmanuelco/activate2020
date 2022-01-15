@extends('layouts.app')
@section('content')
    @include('includes.show', [
                                    'title' => 'Categorias',
                                    'description'=> 'Categorías de locales comerciales',
                                    'html'  =>  'pages.markets.fields_readonly',
                                    'object' => $market,
                               ])
@endsection
