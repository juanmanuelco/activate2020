@extends('layouts.app')
@section('content')
    @include('includes.form', [
                                    'title' => 'Tarjetas',
                                    'description'=> 'Con beneficios',
                                    'route'=> 'card.update',
                                    'method' => 'PUT',
                                    'html'  =>  'pages.cards.fields',
                                    'object' => $card,
                                    'files'     =>  false
                               ])
@endsection
