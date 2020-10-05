<div style="margin-top:-25px;">
    @if (count($errors)>0)
        <div class="mensaje-error-sistema animated flash">
            <h4 class="calibri" >
                @foreach ($errors->all() as $error)
                    {{ $error }},
                @endforeach
            </h4>
        </div>
    @endif
    @if (session('status'))
        <div class="mensaje-bien-sistema animated flash">
            <h4 class="calibri">{{ session('status') }}</h4>
        </div>
    @endif

    @if (session('error'))
        <div class="mensaje-error-sistema animated flash">
            <h4 class="calibri">{{ session('error') }}</h4>
        </div>
    @endif

</div>

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
    .calibri{
        padding-left: 20px
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
        color: white !important;
    }
</style>
