@if(isset($custom))
    {!! $custom->{'gjs-html'} !!}}
    <style>
        {!! $custom->{'gjs-css'} !!}
    </style>
@else

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">


    <link href="http://fonts.cdnfonts.com/css/rounded-elegance" rel="stylesheet">
    <style>
        body{
            font-family: 'Rounded Elegance', sans-serif;
        }
    </style>
    <nav class="navbar navbar-expand-lg navbar-light bg-light" style="border-bottom: 1px solid #3c3d41">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="{{getConfiguration('image', 'LOGOTIPO')}}" width="70px" alt="{{env('APP_NAME')}}">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarScroll">
                <ul class="navbar-nav me-auto my-2 my-lg-0 left_spacing" style="--bs-scroll-height: 100px;">
                    <li class="nav-item">
                        <a class="nav-link"  href="#">Servicios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Funcionamiento</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Productos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">¿Quienes somos?</a>
                    </li>
                </ul>
                <div class="d-flex">
                    <div style="background-color: #3c3d41; border-radius: 50%; padding:5px; margin:10px">
                        <img src="{{getConfiguration('image', 'WHATTSAPP')}}" height="20px" alt="Whattsapp">
                    </div>
                    <div style="background-color: #3c3d41; border-radius: 50%; padding:5px; margin:10px">
                        <img src="{{getConfiguration('image', 'INSTAGRAM')}}" height="20px" alt="Instagram">
                    </div>
                    <div style="background-color: #3c3d41; border-radius: 50%; padding:5px; margin:10px">
                        <img src="{{getConfiguration('image', 'FACEBOOK')}}" height="20px" alt="facebook">
                    </div>
                </div>
            </div>
        </div>
    </nav>

    @include('guest')

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
@endif
