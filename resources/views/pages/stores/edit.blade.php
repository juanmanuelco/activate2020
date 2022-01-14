@extends('layouts.app')
@section('content')
    @include('includes.form', [
                                    'title' => 'Locales comerciales',
                                    'description'=> 'Tiendas, restaurantes, discotecas, etc...',
                                    'route'=> 'store.update',
                                    'method' => 'PUT',
                                    'html'  =>  'pages.stores.fields',
                                    'object' => $store,
                                    'files'     =>  true
                               ])
@endsection
