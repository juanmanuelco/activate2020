@extends('layouts.app')
@section('content')
    @include('includes.form', [
                                    'tittle' => 'Notificaciones',
                                    'description'=> 'Notificaciones push a los usuarios del sistema',
                                    'route'=> 'notification.store',
                                    'method' => 'POST',
                                    'html'  =>  'pages.notifications.fields',
                                    'object' => null,
                                    'files'     =>  false
                               ])
@endsection
