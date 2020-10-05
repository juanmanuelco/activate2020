@extends('layouts.app')
@section('content')
    @include('includes.form', [
                                    'tittle' => 'Roles',
                                    'description'=> 'Son roles necesarios para asignar permisos',
                                    'route'=> 'role.store',
                                    'method' => 'POST',
                                    'html'  =>  'pages.roles.fields',
                                    'object' => null,
                                    'files'     =>  false
                               ])
@endsection
