@extends('layouts.app')
@section('content')
    @include('includes.form', [
                                    'title' => 'Beneficios',
                                    'description'=> 'Beneficios que otorga este local comercial',
                                    'route'=> 'benefit.store',
                                    'method' => 'POST',
                                    'html'  =>  'pages.benefits.fields',
                                    'object' => null,
                                    'files'     =>  false
                               ])
@endsection
