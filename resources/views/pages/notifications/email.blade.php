@extends('layouts.app')
@section('content')
    @include('includes.form', [
                                    'title' => 'E-mails',
                                    'description'=> 'Envío de correos masivos',
                                    'route'=> 'notification.mailing',
                                    'method' => 'POST',
                                    'html'  =>  'pages.notifications.email_fields',
                                    'object' => null,
                                    'files'     =>  true
                               ])
@endsection
