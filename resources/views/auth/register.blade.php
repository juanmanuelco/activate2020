@extends('layouts.guest')

@section('content')
<div class="container container_data" >

    <div class="card register" >
        <article class="card-body">
            <h4 class="card-title mt-3 text-center text-white">{{__('create_account')}}</h4>
            <img src="{{asset('images/brand.png')}}" alt="Logotipo" width="50%" style="margin-bottom: 10px">
            <div class='g-sign-in-button'>
                <div class=content-wrapper>
                    <div class='logo-wrapper'>
                        <img src='{{asset('images/g-logo.png')}}'>
                    </div>
                    <span class='text-container'>
                        <span>{{__('login_google')}}</span>
                    </span>
                </div>
            </div>

            <a href="" class="btn btn-block btn-facebook"> <i class="fab fa-facebook-f"></i>   {{__('login_facebook')}}</a>
            <p class="divider-text">
                <span class="bg-light">{{__('or')}}</span>
            </p>
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="form-group input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                    </div>
                    <input class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="{{ __('Name') }}" type="text">
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div> <!-- form-group// -->
                <div class="form-group input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
                    </div>
                    <input class="form-control @error('email') is-invalid @enderror" name="email" placeholder="{{__('E-Mail Address')}}" type="email" value="{{ old('email') }}" required autocomplete="name" autofocus>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                </div> <!-- form-group// -->
                <div class="form-group input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"> <i class="fa fa-phone"></i> </span>
                    </div>
                    <select class="custom-select" style="max-width: 120px;" name="country" required>
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
                </div> <!-- form-group// -->
                <label for="" class="text-white">{{__('birth')}}</label>
                <div class="form-group input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"> <i class="fa fa-birthday-cake"></i> </span>
                    </div>
                    <input class="form-control  @error('birth') is-invalid @enderror" name="birth" required placeholder="{{ __('birth') }}" type="date" >
                    @error('birth')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>


                <label for="" class="text-white">{{__('roles')}}</label>
                <div class="form-group input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"> <i class="fa fa-building"></i> </span>
                    </div>
                    <select class="form-control" multiple size="4" name="permission[]" required>
                        @foreach(Spatie\Permission\Models\Role::all()->where('id', '>', 2) as $rol)
                            <option value="{{$rol->id}}" @if($rol->id == 3) selected @endif>■ {{$rol->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                    </div>
                    <input class="form-control  @error('password') is-invalid @enderror" name="password"  placeholder="{{ __('Password') }}" type="password" required autocomplete="new-password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                    </div>
                    <input class="form-control" name="password_confirmation" placeholder="{{ __('Confirm Password') }}" type="password" required autocomplete="new-password">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block"> {{ __('Register') }}  </button>
                </div>
                <p class="text-center">Have an account? <a href="">Log In</a> </p>
            </form>
        </article>
    </div>
</div>
@endsection
