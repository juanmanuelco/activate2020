@extends('layouts.app')
@section('content')
    @include('includes.form', [
                                    'title' => 'Usuarios',
                                    'description'=> 'usuarios del sistema',
                                    'route'=> 'user.store',
                                    'method' => 'POST',
                                    'html'  =>  'pages.users.fields',
                                    'object' => null,
                                    'files'     =>  false
                               ])
@endsection
