@extends('layouts.app')
@section('content')
    @include('includes.form', [
                                    'title' => 'Categorias',
                                    'description'=> 'Categorias de locales comerciales',
                                    'route'=> 'category.store',
                                    'method' => 'POST',
                                    'html'  =>  'pages.categories.fields',
                                    'object' => null,
                                    'files'     =>  false
                               ])
@endsection
