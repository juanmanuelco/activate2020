<!DOCTYPE html>
<html lang="es">
@include('includes.head')
<body id="page-top">
<div id="wrapper">
    @include('includes.menu')
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            <div class="animationload" id="loading_gif" style="display: block">
                <button class="btn btn-light close-loading" ><i class="fa fa-close"></i></button>
                <div class="osahanloading"></div>
            </div>
            <div id="app" >
                  @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'builder.create' || \Illuminate\Support\Facades\Route::currentRouteName() == 'builder.edit')
                      <div>
                          @include('includes.navbar')
                          <div>
                  @else
                      <div style="height: 100%; ">
                          @include('includes.navbar')
                          <div style="padding-left: 15px; padding-right: 15px">
                  @endif
                      @yield('content')
                          </div>
                      </div>
            </div>
        </div>
        @include('includes.footer')
    </div>
</div>
@include('includes.scripts')
    <script>
        $('.close-loading').click((event)=>{
            document.getElementById('loading_gif').style.display = 'none';
        })
    </script>
</body>
</html>
