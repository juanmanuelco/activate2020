@extends('layouts.app')
@section('content')
    @include('includes.form', [
                                    'tittle' => 'Permisos',
                                    'description'=> 'Acceso a vinculos y rutas de servidor',
                                    'route'=> 'permission.update',
                                    'method' => 'PUT',
                                    'html'  =>  'pages.permissions.fields',
                                    'object' => $permission,
                                    'files'     =>  false
                               ])
@endsection
