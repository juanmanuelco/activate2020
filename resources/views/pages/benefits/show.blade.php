@extends('layouts.app')
@section('content')
    @include('includes.show', [
                                    'title' => 'Beneficios',
                                    'description'=> 'Beneficios que otorga este local comercial',
                                    'html'  =>  'pages.benefits.fields_readonly',
                                    'object' => $benefit,
                               ])
@endsection
