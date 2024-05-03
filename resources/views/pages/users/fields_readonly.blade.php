
<div class="row">
    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
            {!! Form::label('name', __('Name')); !!}
            : {{$object->name}}

        </div>

        <div class="form-group">
            {!! Form::label('email', __('Email')); !!}
            : {{$object->email}}

        </div>

    </div>
</div>
