@extends('layouts.app')
@section('content')
    @include('includes.form', [
                                    'title' => 'Categorías',
                                    'description'=> 'Categorías de locales comerciales',
                                    'route'=> 'category.update',
                                    'method' => 'PUT',
                                    'html'  =>  'pages.categories.fields',
                                    'object' => $category,
                                    'files'     =>  true
                               ])
@endsection
