


<div class="row" style="padding:1%">
    <div class="col-lg-3" style=" padding-top:2%">
        <h3 class="blue_text">Registro gratuito</h3>
        <form method="POST" action="{{ route('login') }}" style="padding-left: 5px; padding-top:25px"  class="form-login" >
            @csrf
            <div class="row">
                <div class="col-md-5" >
                    <h4>Prueba con</h4>
                </div>
                <div class="col-md-7" style="text-align: right">
                    <img src="{{getConfiguration('image', 'LOGIN_FACEBOOK')}}" alt="" width="50px" style="padding-left:15px">
                    <img src="{{getConfiguration('image', 'LOGIN_GOOGLE')}}" alt="" width="50px" style="padding-left:15px">
                </div>
            </div>
            <div style="padding-top:20px">
                <div class="form-group row" style="padding-bottom:25px">
                    <input id="email" placeholder="E-mail" type="email" class="form-control rounded @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                </div>

                <div class="form-group row"  style="padding-bottom:25px">
                    <input id="password" placeholder="Contraseña" type="password" class="form-control rounded @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                    @error('password')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror

                </div>
            </div>



{{--            <div class="form-group row">--}}
{{--                <div class="col-md-6 offset-md-4">--}}
{{--                    <div class="form-check">--}}
{{--                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>--}}

{{--                        <label class="form-check-label" for="remember">--}}
{{--                            {{ __('Remember Me') }}--}}
{{--                        </label>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

            <div class="row">
                <div class="col-md-5" >
                    @if (Route::has('password.request'))
                        <a class="btn btn-link" style="font-size: 80%; color:#52b0c9; font-weight: bold " href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    @endif
                </div>
                <div class="col-md-7" style="text-align: right">
                    <button class="btn button-black" type="button" onclick="location.replace('{{route('register')}}')">
                        {{ __('Register') }}
                    </button>

                    <button type="submit" class="btn button-black">
                        {{ __('Login') }}
                    </button>
                </div>
            </div>
        </form>

        <div style="padding-left: 5px; padding-top:25px" >
            <h5>Descarga nuestra app</h5>
            <img src="{{getConfiguration('image', 'APPSTORE')}}"  width="130px">
            <img src="{{getConfiguration('image', 'GOOGLE_STORE_IMG')}}"  width="130px">
        </div>

        <div style="padding-left: 5px; padding-top:25px"  class="form-login">
            <iframe width="100%" height="315" src="https://www.youtube.com/embed/XzwNBVRt_gs" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

            <div style="text-align: center; padding-top: 25px; padding-bottom:25px">
                <img src="{{getConfiguration('image', 'PROPUESTA')}}" style="margin:0 auto"  width="100%">
            </div>
        </div>

    </div>
    <div class="col-lg-9 " style=" padding-top:2%; padding-left:1%; padding-right:1%">
       <div >
           <div style="text-align: center">

              <div class="padding_image">
                  <img src="{{getConfiguration('image', 'LOGO_HOME')}}" width="200px" alt="">
                  <h5>DONDE DEBES ESTAR</h5>
              </div>

               <div class="padding_image">
                   <img src="{{getConfiguration('image', 'ALIADOS')}}" width="200px" alt="">
               </div>

               @php
                   use App\Models\Card;
                    $cards = Card::query()->where('hidden', false)->get();
               @endphp

               <div style="overflow-y: hidden; overflow-x: scroll;  display: inline-flex" class="carousel_card">
                   @foreach($cards as $key=> $card)
                       <div style="display: inline-flex">
                           <img style="border-radius: 25px; margin-left:25px;margin-right:25px" width="300px" src="{{ '/images/system/' . $card->getImage()->id . '.' . $card->getImage()->extension}}" alt="{{$card->getImage()->name}}">
                       </div>
                   @endforeach
               </div>

               <div class="padding_image">
                   <img src="{{getConfiguration('image', 'COMPRALA')}}" width="200px" alt="">
               </div>

               <div class="padding_image">
                   <img src="{{getConfiguration('image', 'CREDIT_CARD')}}" width="200px" alt="">
               </div>

           </div>
       </div>
    </div>
</div>

<style>
    .carousel_card{
        max-width: 80%;
    }
    .flex{
        display: -webkit-box;
        display: -moz-box;
        display: -ms-flexbox;
        display: -moz-flex;
        display: -webkit-flex;
        display: flex;
        -webkit-flex-wrap: wrap;
        flex-wrap: wrap;
    }
    .blue_text{
        color: #52b0c9;
        font-weight: bold;
    }
    .rounded{
        border-radius: 25px !important;
    }
    .form-login{
        /*max-width: 400px;*/
    }
    .button-black{
        border-radius: 25px;
        paddding:10px;
        color:white;
        background-color: #3c3d41;
    }
    .padding_image{
        padding-top: 20px;
        padding-bottom: 20px;
    }

    @media (min-width: 768px){
        .left_spacing{
            padding-left:200px;
        }
        .carousel_card{
            max-width: 60%;
        }
    }

</style>
