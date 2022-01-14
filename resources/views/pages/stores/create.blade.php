@extends('layouts.app')
@section('content')
    @include('includes.form', [
                                    'title' => 'Locales comerciales',
                                    'description'=> 'Tiendas, restaurantes, discotecas, etc...',
                                    'route'=> 'store.store',
                                    'method' => 'POST',
                                    'html'  =>  'pages.stores.fields',
                                    'object' => null,
                                    'files'     =>  false
                               ])
@endsection
