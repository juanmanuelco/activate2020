
<div class="row">
    <div class="col-lg-8 col-md-6 col-sm-12 col-xs-12">

        @if(!empty($card->getCard()->getImage()))
            <img width="30%" src="<?php echo  '/images/system/' . $card->getCard()->getImage()->id . '.' . $card->getCard()->getImage()->extension ?>" alt="{{$card->getCard()->getImage()->name}}">

        @endif

        <div style="margin: 25px">
            <h1>{{__('Number')}} : <strong>{{$card->number}}</strong></h1>
        </div>

        <input type="hidden" name="card" value="{{$card->id}}">
        <div class="form-group">
            {!! Form::label('email', __('Email of customer')); !!}
            {!! Form::email('email',old('email'), ['class'=> 'form-control', 'required'=> true]); !!}
        </div>

    </div>
</div>
