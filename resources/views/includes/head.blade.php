<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" type="image/png" href="{{asset('images/brand.png')}}"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ asset('css/app.css') }}"></script>
    <title>{{env('APP_NAME')}}</title>
    @if(Illuminate\Support\Facades\Route::currentRouteName() != 'page_name')
        @include('includes.styles')
    @endif
    <link rel="stylesheet" href="{{asset('css/menu.css')}}">
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <link rel="stylesheet" href="{{asset('css/bootstrap-datetimepicker.css')}}">
    @yield('custom_styles')
    <script>
        Notification.requestPermission();
        if (navigator.geolocation)  navigator.geolocation.getCurrentPosition(()=>{});
    </script>
</head>
