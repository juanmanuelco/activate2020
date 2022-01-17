




<div class="container container_data" >
    @include('includes.messages')

    <div class="row">
        <div class="col-12" style="padding-top:10px">
            <div style="text-align: center; ">
                <h4 class="">{{__('create_account')}}</h4>
                <img src="{{getConfiguration('image', 'LOGO_HOME')}}" width="200px" alt="">
            </div>


            <div class="row" style="padding-bottom: 25px">
                <div class="col-md-5" >
                    <h2>Prueba con</h2>
                </div>
                <div class="col-md-7" style="text-align: right">
                    <img src="{{getConfiguration('image', 'LOGIN_FACEBOOK')}}" alt="" width="50px" style="padding-left:15px">
                    <img src="{{getConfiguration('image', 'LOGIN_GOOGLE')}}" alt="" width="50px" style="padding-left:15px">
                </div>
            </div>
            <form method="POST" action="{{ route('register') }}">
            @csrf
                <div class="form-group">
                    <label for="">Nombre</label>
                    <input class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="{{ __('Name') }}" type="text">
                    @error('name')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="">Correo electrónico</label>
                    <input class="form-control @error('email') is-invalid @enderror" name="email" placeholder="{{__('E-Mail Address')}}" type="email" value="{{ old('email') }}" required autocomplete="name" autofocus>
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group input-group">
                    <select class="custom-select" style="max-width: 180px;" name="country" required>
                        @php
                            use App\Models\Country;$countries = Country::get();
                        @endphp
                        @foreach($countries as $country)
                            <option value="{{$country->id}}" @if($country->iso == 'EC') selected @endif>
                                {{$country->nicename . ' +' . $country->phonecode}}
                            </option>
                        @endforeach
                    </select>
                    <input name="phone" class="form-control" required placeholder="{{__('phone')}}" type="text">
                </div>

                <div class="form-group ">
                    <label for="">Fecha de nacimiento</label>
                    <input class="form-control  @error('birth') is-invalid @enderror" name="birth" required placeholder="{{ __('birth') }}" type="date" >
                    @error('birth')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <label for="" class="">{{__('roles')}}</label>
                <div class="form-group input-group">
                    <select class="form-control" multiple size="4" name="permission[]" required>
                        @foreach(Spatie\Permission\Models\Role::all()->where('public', '=', true) as $rol)
                            <option value="{{$rol->id}}" @if($rol->id == 2) selected @endif>■ {{$rol->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group input-group">
                    <input class="form-control  @error('password') is-invalid @enderror" name="password"  placeholder="{{ __('Password') }}" type="password" required autocomplete="new-password">
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group input-group">
                    <input class="form-control" name="password_confirmation" placeholder="{{ __('Confirm Password') }}" type="password" required autocomplete="new-password">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn button-black btn-block"> {{ __('Register') }}  </button>
                </div>
                <p class="text-center">¿Tienes una cuneta? <a href="/">Iniciar sesión</a> </p>

            </form>
        </div>

    </div>




</div>


<style>

    .button-black{
        border-radius: 25px;
        paddding:10px;
        color:white;
        background-color: #3c3d41;
    }


    .form-group{
        padding-bottom:10px;
        padding-top: 10px;
    }

</style>
