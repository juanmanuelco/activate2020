@extends('layouts.guest')

@section('content')

    <div class="site-wrapper" >

        <div class="site-wrapper-inner">

            <div class="container">

                <div class="inner cover">
                    <div class="image_cover">
                        <img src="{{asset('images/brand.png')}}" width="70%" alt="">
                    </div>
                    <h2 class="cover-heading text-white">{{__('slogan')}}</h2>

                    <p class="lead" STYLE="margin-top: 25px">
                        <a href="{{route('login')}}" class="btn btn-lg sun">{{__('login')}}</a>
                        <a href="{{route('register')}}" class="btn btn-lg sun">{{__('register')}}</a>
                    </p>
                    <div class="container content_app_button" >
                        <div class="app_button">
                            <img src="{{asset('images/google_play.png')}}" alt="Google play" width="100%">
                        </div>
                        <div class="app_button">
                            <img src="{{asset('images/apple_store.png')}}" alt="Apple Store" width="100%">
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
@endsection
