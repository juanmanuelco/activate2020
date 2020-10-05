@extends('layouts.app')
@section('content')
    @include('includes.form', [
                                    'tittle' => 'Roles',
                                    'description'=> 'Son roles necesarios para asignar permisos',
                                    'route'=> 'role.update',
                                    'method' => 'PUT',
                                    'html'  =>  'pages.roles.fields',
                                    'object' => $role,
                                    'files'     =>  false
                               ])
@endsection
