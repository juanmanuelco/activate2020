<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="{{getConfiguration('text', 'DESCRIPCION')}}">
    <meta name="author" content="{{getConfiguration('text', 'AUTOR')}}">
    <link rel="shortcut icon" type="image/png" href="{{getConfiguration('image', 'LOGOTIPO')}}"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        :root {
            --background: {{getConfiguration('color', 'COLOR-PRINCIPAL')}};
            --text_color: {{getConfiguration('color', 'TEXTO-COLOR-PRINCIPAL')}};
            --hover_link: {{getConfiguration('color', 'HOVER-MENU')}};
            --hover_item : {{getConfiguration('color', 'ITEM-HOVER')}};
            --footer_background : {{getConfiguration('color', 'FOOTER-FONDO')}};
            --cancel: {{getConfiguration('color', 'CANCELAR-COLOR')}};
            --confirm: {{getConfiguration('color', 'CONFIRMAR-COLOR')}}
        }
    </style>
    <script>
        var NO_ELIMINO = @json(getConfiguration('text', 'NO-ELIMINO'));
        var GUARDADO = @json(getConfiguration('text', 'GUARDADO'));
    </script>
    <script src="{{ asset('css/app.css') }}"></script>
    <title>{{getConfiguration('text', 'NOMBRE-SITIO')}}</title>
    @include('includes.styles')
    <link rel="stylesheet" href="{{asset('css/menu.css')}}">
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <link rel="stylesheet" href="{{asset('css/bootstrap-datetimepicker.css')}}">
    @yield('custom_styles')
</head>
