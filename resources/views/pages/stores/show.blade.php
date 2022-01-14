@extends('layouts.app')
@section('content')
    @include('includes.show', [
                                    'title' => 'Categorias',
                                    'description'=> 'Categorías de locales comerciales',
                                    'html'  =>  'pages.stores.fields_readonly',
                                    'object' => $store,
                               ])
@endsection
