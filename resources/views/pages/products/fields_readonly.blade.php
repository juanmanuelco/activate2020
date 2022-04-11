
<div class="row">
    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
            {!! Form::label('name', __('Name')); !!}
            : {{$object->name}}

        </div>

        <div class="form-group">
            {!! Form::label('description', __('Description')); !!}
            : {{$object->description}}

        </div>

        <div class="form-group">
            {!! Form::label('code', __('Code')); !!}
            : {{$object->code}}
        </div>

        <div class="form-group">
            {!! Form::label('price', __('Price')); !!}
            : {{$object->price}}
        </div>

        @if(!empty($object->getImage()))
            <img width="400px" src="<?php echo $object->getImage()->permalink ?>">
        @endif

    </div>
</div>
