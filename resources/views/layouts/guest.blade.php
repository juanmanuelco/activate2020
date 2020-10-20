<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Activate') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/styles.css')}}">
    <link rel="stylesheet" href="{{asset('css/guest.css')}}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
    <link rel="shortcut icon" type="image/png" href="{{asset('images/brand.png')}}"/>
</head>
<body style="background-color:var(--background, #000000)">
    <div id="app">
        <div class="site-wrapper">
            <div class="site-wrapper-inner">
                <div class="container">
                    <div class="masthead clearfix">
                        <div class="container inner">
                            <nav class="text-white">
                                <ul class="nav masthead-nav">
                                    <li><a href="#">Nosotros</a></li>
                                    <li><a href="#">Servicios</a></li>
                                    <li><a href="#">Contactos</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                    @yield('content')
                </div>
            </div>
        </div>

    </div>
</body>
</html>
