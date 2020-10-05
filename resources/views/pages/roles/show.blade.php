@extends('layouts.app')
@section('content')
    @include('includes.show', [
                                    'tittle' => 'Grupos',
                                    'description'=> 'Grupos de enlaces que se mostrarán en el menú izquierdo',
                                    'html'  =>  'pages.roles.fields_readonly',
                                    'object' => $role,
                               ])
@endsection
