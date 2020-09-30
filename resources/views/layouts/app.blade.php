<!DOCTYPE html>
<html lang="es">
@include('includes.head')
<body id="page-top">
<div id="wrapper">
    @include('includes.menu')
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
          <div id="app" >
              @include('includes.navbar')
              @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'builder.create' || \Illuminate\Support\Facades\Route::currentRouteName() == 'builder.edit')
                  <div>
              @else
                  <div style="padding: 0px 10px 0px 10px;text-align: center">
              @endif
                  @include('includes.messages')
                  @yield('content')
              </div>
          </div>
        </div>
        @include('includes.footer')
    </div>
</div>
@include('includes.scripts')
</body>
</html>
