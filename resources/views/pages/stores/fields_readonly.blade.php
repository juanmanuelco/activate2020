
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

        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    {!! Form::label('facebook', __('Facebook')); !!}
                    : {{$object->facebook}}
                </div>

                <div class="form-group">
                    {!! Form::label('instagram', __('Instagram')); !!}
                    : {{$object->instagram}}
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    {!! Form::label('web_page', __('Web page')); !!}
                    : {{$object->web_page}}
                </div>

                <div class="form-group">
                    {!! Form::label('phone', __('Phone')); !!}
                    : {{$object->phone}}
                </div>
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('category', __('Category')); !!}
            : {{$object->category()->name}}

        </div>

        <div class="form-group">
            {!! Form::label('owner', __('Owner')); !!}
            : {{$object->owner()->name}}
        </div>



        <div class="form-group">
            {!! Form::label('schedule', __('Schedule')); !!}
            : {{$object->schedule}}
        </div>

        @if(!empty($object->getImage()))
            <img width="400px" src="<?php echo  '/images/system/' . $object->getImage()->id . '.' . $object->getImage()->extension ?>" alt="<?php echo $object->getImage()->name ?>">
        @endif

    </div>
</div>
