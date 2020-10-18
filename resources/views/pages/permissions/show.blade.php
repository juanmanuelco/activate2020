@extends('layouts.app')
@section('content')
    @include('includes.show', [
                                   'title' => 'Permisos',
                                    'description'=> 'Acceso a vinculos y rutas de servidor',
                                    'html'  =>  'pages.permissions.fields_readonly',
                                    'object' => $permission,
                               ])
@endsection
