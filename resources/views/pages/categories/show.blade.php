@extends('layouts.app')
@section('content')
    @include('includes.show', [
                                    'title' => 'Categorias',
                                    'description'=> 'Categorías de locales comerciales',
                                    'html'  =>  'pages.categories.fields_readonly',
                                    'object' => $category,
                               ])
@endsection
