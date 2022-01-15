@extends('layouts.app')
@section('content')
    @include('includes.form', [
                                    'title' => 'Beneficios',
                                    'description'=> 'Beneficios que otorga este local comercial',
                                    'route'=> 'benefit.update',
                                    'method' => 'PUT',
                                    'html'  =>  'pages.benefits.fields',
                                    'object' => $benefit,
                                    'files'     =>  false
                               ])
@endsection
