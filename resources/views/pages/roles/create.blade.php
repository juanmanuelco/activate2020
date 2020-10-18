@extends('layouts.app')
@section('content')
    @include('includes.form', [
                                    'title' => 'Roles',
                                    'description'=> 'Son roles necesarios para asignar permisos',
                                    'route'=> 'role.store',
                                    'method' => 'POST',
                                    'html'  =>  'pages.roles.fields',
                                    'object' => null,
                                    'files'     =>  false
                               ])
@endsection
