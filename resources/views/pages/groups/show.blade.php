@extends('layouts.app')
@section('content')
    @include('includes.show', [
                                    'title' => 'Grupos',
                                    'description'=> 'Grupos de enlaces que se mostrarán en el menú izquierdo',
                                    'html'  =>  'pages.groups.fields_readonly',
                                    'object' => $group,
                               ])
@endsection
