@extends('layouts.app')
@section('content')
    @include('includes.form', [
                                    'title' => 'Tarjetas',
                                    'description'=> 'Con beneficios',
                                    'route'=> 'card.store',
                                    'method' => 'POST',
                                    'html'  =>  'pages.cards.fields',
                                    'object' => null,
                                    'files'     =>  false
                               ])
@endsection
