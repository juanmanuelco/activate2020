@extends('layouts.app')
@section('content')
    @include('includes.form', [
                                    'title' => 'Productos',
                                    'description'=> 'Productos disponibles',
                                    'route'=> 'product.update',
                                    'method' => 'PUT',
                                    'html'  =>  'pages.products.fields',
                                    'object' => $product,
                                    'files'     =>  true
                               ])
@endsection
