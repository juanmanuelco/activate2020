@extends('layouts.app')
@section('content')
    @include('includes.show', [
                                    'title' => 'Productos',
                                    'description'=> 'Productos disponibles',
                                    'html'  =>  'pages.products.fields_readonly',
                                    'object' => $product,
                               ])
@endsection
