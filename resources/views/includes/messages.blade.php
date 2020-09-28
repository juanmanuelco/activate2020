@if (count($errors)>0)
    <div class="centrado  mensaje-error-sistema animated flash">
        <h4 class="calibri" style="color:red">
            @foreach ($errors->all() as $error)
                {{ $error }},
            @endforeach
        </h4>
    </div>
@endif
@if (session('status'))
    <div class="centrado  mensaje-bien-sistema animated flash">
        <h4 class="calibri" style=" color: #068194">{{ session('status') }}</h4>
    </div>
@endif

@if (session('error'))
    <div class="centrado  mensaje-error-sistema animated flash">
        <h4 class="calibri" style="color:red">{{ session('error') }}</h4>
    </div>
@endif


<style>
    .mensaje-error-sistema{

        background-color:rgba(180, 000, 000, 0.9);
        padding-top: 6px;
        padding-bottom: 6px;
        margin-bottom: 12px;
    }

    .mensaje-bien-sistema{

        background-color:rgba(39, 91, 233, 0.952);
        padding-top:6px;
        padding-bottom:6px;
        margin-bottom: 12px;
    }


    .animated {
        -webkit-animation-duration: 2s;
        animation-duration: 2s;
        -webkit-animation-fill-mode: both;
        animation-fill-mode: both;
    }
    @-webkit-keyframes flash {
        0%, 50%, 100% {
            opacity: 1;
        }
        25%, 75% {
            opacity: 0;
        }
    }
    @keyframes flash {
        0%, 50%, 100% {
            opacity: 1;
        }
        25%, 75% {
            opacity: 0;
        }
    }
    .flash {
        -webkit-animation-name: flash;
        animation-name: flash;
    }
</style>
