@extends('layouts.app')
@section('content')
    @include('includes.form', [
                                    'title' => 'Roles',
                                    'description'=> 'Son roles necesarios para asignar permisos',
                                    'route'=> 'role.update',
                                    'method' => 'PUT',
                                    'html'  =>  'pages.roles.fields',
                                    'object' => $role,
                                    'files'     =>  false
                               ])
@endsection
