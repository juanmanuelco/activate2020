<!DOCTYPE html>
<html lang="es">
@include('includes.head')
<body id="page-top">
<div id="wrapper">
    @include('includes.menu')
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            <div class="animationload" id="loading_gif" style="display: block">
                <div class="osahanloading"></div>
            </div>
            <div id="app" >
                <div style="height: 100%; ">
                    @include('includes.navbar')
                <div style="padding-left: 15px; padding-right: 15px">
                    @yield('content')
                </div>
            </div>
        </div>
        @include('includes.footer')
        <a class="scroll-to-top rounded" href="#page-top"><i class="fas fa-angle-up"></i></a>
    </div>
</div>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{asset('js/code.js')}}"></script>
    @yield('image_vue')
    @yield('new_scripts')
    @yield('vue_scripts')
    <script src="{{asset('js/sb-admin-2.min.js')}}"></script>
    <script>
        document.getElementById('loading_gif').style.display = 'none';
        @if(auth()->check() && auth()->user()->show_location)
        if (navigator.geolocation)  navigator.geolocation.getCurrentPosition((position)=>{
            let data = {'latitude' : position.coords.latitude, 'longitude' : position.coords.longitude};
            $.ajax(location.origin + '/location', {
                method: 'POST',
                data: data,
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });
        });
        @endif
    </script>
</body>
</html>
