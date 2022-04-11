@extends('layouts.app')
@section('content')
    @include('includes.form', [
                                    'title' => 'Productos',
                                    'description'=> 'Productos disponibles',
                                    'route'=> 'product.store',
                                    'method' => 'POST',
                                    'html'  =>  'pages.products.fields',
                                    'object' => null,
                                    'files'     =>  false
                               ])
@endsection
