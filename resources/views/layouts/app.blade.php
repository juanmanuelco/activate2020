<!DOCTYPE html>
<html lang="es">
@include('includes.head')
<body id="page-top">
<div id="wrapper">
    @include('includes.menu')
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
                <div class="animationload" id="loading_gif" style="display: none">
                    <button class="btn btn-light close-loading" ><i class="fa fa-close"></i></button>
                    <div class="osahanloading"></div>
                </div>
              <div id="app" >
                  @include('includes.navbar')
                  @include('includes.messages')
                  @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'builder.create' || \Illuminate\Support\Facades\Route::currentRouteName() == 'builder.edit')
                      <div>
                  @else
                      <div style="padding: 0px 10px 0px 10px;text-align: center">
                  @endif
                      @yield('content')
              </div>
            </div>
        </div>
        @include('includes.footer')
    </div>
</div>
@include('includes.scripts')
    <script>
        $('.close-loading').click((event)=>{
            document.getElementById('loading_gif').style.display = 'none'
        })
    </script>
</body>
</html>
