@extends('layouts.app')
@section('content')
    @include('includes.form', [
                                    'title' => 'Usuarios',
                                    'description'=> 'del sistema',
                                    'route'=> 'user.update',
                                    'method' => 'PUT',
                                    'html'  =>  'pages.users.fields',
                                    'object' => $user,
                                    'files'     =>  false
                               ])
@endsection
