<div style="width: 100%">
    <div class="row">
        <div class="col-lg-4"></div>
        <div class="col-lg-4" style="padding-top: 150px">

            <h2 style="text-align: center">Bienvenido al sistema</h2>
            <form method="POST" action="{{ route('login') }}" style="padding-left: 5px; padding-top:25px"  class="form-login" >
                @csrf
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
                <div class="row">
                    <div class="col-md-5" >
                        @if (Route::has('password.request'))
                            <a class="btn btn-link" style="font-size: 80%; color:#52b0c9; font-weight: bold " href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        @endif
                    </div>
                    <div class="col-md-7" style="text-align: right">
                        <button type="submit" class="btn btn-dark">
                            {{ __('Login') }}
                        </button>
                    </div>
                </div>
            </form>

        </div>
        <div class="col-lg-4"></div>
    </div>
</div>
