<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{env('APP_NAME')}}</title>
    @if(Illuminate\Support\Facades\Route::currentRouteName() != 'page_name')
        @include('includes.styles')
    @endif
    <style>
        .animationload {
            background-color: rgba(255,255,255,0.6);
            height: 100%;
            left: 0;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 10000;
        }
        .osahanloading {
            animation: 1.5s linear 0s normal none infinite running osahanloading;
            background: #fed37f none repeat scroll 0 0;
            border-radius: 50px;
            height: 50px;
            left: 50%;
            margin-left: -25px;
            margin-top: -25px;
            position: absolute;
            top: 50%;
            width: 50px;
        }
        .osahanloading::after {
            animation: 1.5s linear 0s normal none infinite running osahanloading_after;
            border-color: #85d6de transparent;
            border-radius: 80px;
            border-style: solid;
            border-width: 10px;
            content: "";
            height: 80px;
            left: -15px;
            position: absolute;
            top: -15px;
            width: 80px;
        }
        @keyframes osahanloading {
            0% {
                transform: rotate(0deg);
            }
            50% {
                background: #85d6de none repeat scroll 0 0;
                transform: rotate(180deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>
