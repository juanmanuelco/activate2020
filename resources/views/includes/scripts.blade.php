<script src="{{ asset('js/app.js') }}"></script>
<a class="scroll-to-top rounded" href="#page-top"><i class="fas fa-angle-up"></i></a>
<script src="{{asset('vendor/fontawesome-free/js/all.js')}}"></script>
<script src="{{asset('js/code.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
@yield('image_vue')
@yield('new_scripts')
@yield('vue_scripts')

<script src="{{asset('js/sb-admin-2.min.js')}}"></script>
<script src="{{asset('js/images.js')}}"></script>
<script>
    document.getElementById('loading_gif').style.display = 'none';
</script>
<script>
    @if(auth()->check())
    if (navigator.geolocation)  navigator.geolocation.getCurrentPosition((position)=>{
        let data = {'latitude' : position.coords.latitude, 'longitude' : position.coords.longitude};
        $.ajax(location.origin + '/location', {
            method: 'POST',
            data: data,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },

            success: (success) => {
               console.log(success)
            },
            error: (error)=> {
                console.log(error)
            }
        });
    });
    @endif
</script>
