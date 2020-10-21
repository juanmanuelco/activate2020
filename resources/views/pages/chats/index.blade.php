@extends('layouts.app')
@section('custom_styles')
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key={{getConfiguration('text','API-GOOGLE-MAPS')}}&callback=initMap&libraries=&v=weekly"
        defer
    ></script>
@endsection
@section('content')
    <div id="map" style="position: absolute; z-index: 1; overflow: hidden;"></div>
    <div class="chat_zone" >

    </div>
@endsection

@section('new_scripts')
    <script>
        let map;
        function initMap() {
            navigator.geolocation.getCurrentPosition((position)=>{
                map = new google.maps.Map(document.getElementById("map"), {
                    center: { lat: Number(position.coords.latitude), lng: Number(position.coords.longitude) },
                    zoom: {!! getConfiguration('number', 'GOOGLE-MAPS-ZOOM') !!},
                    disableDefaultUI: {!! getConfiguration('boolean', 'GOOGLE-MAPS-UI') !!},
                    styles: {!! getConfiguration('text', 'GOOGLE-MAPS-STYLES') !!}
                });
            })

        }
    </script>

@endsection
