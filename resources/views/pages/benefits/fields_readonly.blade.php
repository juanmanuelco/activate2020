
<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
            {!! Form::label('name', __('Name')); !!}
            : {{$object->name}}
        </div>

        <div class="form-group">
            {!! Form::label('benefit', __('Benefit')); !!}
            : {{$object->benefit}}

        </div>
        <div class="form-group">
            {!! Form::label('restriction', __('Restriction')); !!}
            : {{$object->restriction}}

        </div>

        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    {!! Form::label('store', __('Store')); !!}
                    : {{$object->store()->first()->name}}

                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    {{$object->unlimited ? __('Unlimited use') : __('Only one use')}}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    {!! Form::label('points', __('Points by use')); !!}
                    : {{$object->points}}
                </div>

            </div>
            <div class="col-6">
                <div class="form-group">
                    {!! Form::label('gains', __('Gains by use')); !!}
                    : {{$object->gains}}
                </div>
            </div>
        </div>

        @if(!empty($object->getImage()))
            <img width="400px" src="<?php echo  '/images/system/' . $object->getImage()->id . '.' . $object->getImage()->extension ?>" alt="<?php echo $object->getImage()->name ?>">
        @endif

    </div>
</div>
