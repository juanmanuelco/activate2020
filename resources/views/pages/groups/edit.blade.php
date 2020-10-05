@extends('layouts.app')
@section('content')
    @include('includes.form', [
                                    'tittle' => 'Grupos',
                                    'description'=> 'Grupos de enlaces que se mostrarán en el menú izquierdo',
                                    'route'=> 'group.update',
                                    'method' => 'PUT',
                                    'html'  =>  'pages.groups.fields',
                                    'object' => $group,
                                    'files'     =>  false
                               ])
@endsection
