@extends('layouts.app')
@section('content')
    @include('includes.show', [
                                   'tittle' => 'Permisos',
                                    'description'=> 'Acceso a vinculos y rutas de servidor',
                                    'html'  =>  'pages.permissions.fields_readonly',
                                    'object' => $permission,
                               ])
@endsection
