@if(isset($custom))
    {!! $custom->{'gjs-html'} !!}}
    <style>
        {!! $custom->{'gjs-css'} !!}
    </style>
@else
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <div class="jumbotron">
        <h1 class="display-4">SISTEMA "OPCIÓN"</h1>
        <p class="lead">Software modular para gestión de modelo de negocios.</p>
        <hr class="my-4">
        <p>Es una herramienta escalable, útil para diferentes ámbitos industriales, personales y laborables</p>

    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
@endif
