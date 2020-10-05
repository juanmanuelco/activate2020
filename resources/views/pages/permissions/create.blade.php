@extends('layouts.app')
@section('content')
    @include('includes.form', [
                                    'tittle' => 'Permisos',
                                    'description'=> 'Acceso a vinculos y rutas de servidor',
                                    'route'=> 'permission.store',
                                    'method' => 'POST',
                                    'html'  =>  'pages.permissions.fields',
                                    'object' => null,
                                    'files'     =>  false
                               ])
@endsection
