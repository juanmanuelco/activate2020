@extends('layouts.app')
@section('content')
    @include('includes.show', [
                                    'title' => 'Usuarios',
                                    'description'=> 'ver el usuario',
                                    'html'  =>  'pages.users.fields_readonly',
                                    'object' => $user,
                               ])
@endsection
