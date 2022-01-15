@extends('layouts.app')
@section('content')
    @include('includes.form', [
                                    'title' => 'Asignar tarjeta',
                                    'description'=> 'Para ser vendidas',
                                    'route'=> 'assignments.store',
                                    'method' => 'POST',
                                    'html'  =>  'pages.assignments.fields',
                                    'object' => null,
                                    'files'     =>  false
                               ])
@endsection
