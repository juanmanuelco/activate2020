@extends('layouts.app')
@section('content')
    @include('includes.form', [
                                    'tittle' => 'Grupos',
                                    'description'=> 'Grupos de enlaces que se mostrarán en el menú izquierdo',
                                    'route'=> 'group.store',
                                    'method' => 'POST',
                                    'html'  =>  'pages.groups.fields',
                                    'object' => null,
                                    'files'     =>  false
                               ])
@endsection
