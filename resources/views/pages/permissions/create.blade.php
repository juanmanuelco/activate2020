@extends('layouts.app')
@section('content')
    @include('includes.form', [
                                    'title' => 'Permisos',
                                    'description'=> 'Acceso a vinculos y rutas de servidor',
                                    'route'=> 'permission.store',
                                    'method' => 'POST',
                                    'html'  =>  'pages.permissions.fields',
                                    'object' => null,
                                    'files'     =>  false
                               ])
@endsection
