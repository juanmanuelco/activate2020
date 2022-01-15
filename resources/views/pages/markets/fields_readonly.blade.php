
<div class="row">
    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
            {!! Form::label('name', __('Name')); !!}
            : {{$object->name}}

        </div>


        <div class="form-group">
            {!! Form::label('card', __('Card')); !!}
            : {{$object->card()->name}}

        </div>

        @if(!empty($object->getImage()))
            <img width="400px" src="<?php echo  '/images/system/' . $object->getImage()->id . '.' . $object->getImage()->extension ?>" alt="<?php echo $object->getImage()->name ?>">
        @endif

    </div>
</div>
