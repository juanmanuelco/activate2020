@extends('layouts.app')
@section('content')
    @include('includes.show', [
                                    'title' => 'Tarjetas',
                                    'description'=> 'Con beneficios',
                                    'html'  =>  'pages.cards.fields_readonly',
                                    'object' => $card,
                               ])
@endsection
