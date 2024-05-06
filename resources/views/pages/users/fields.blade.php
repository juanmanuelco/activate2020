<div class="row">
    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
            {!! Form::label('name', __('Name')); !!}
            {!! Form::text('name',old('name'), ['class'=> 'form-control', 'required'=> true]); !!}
            <small id="nameHelp" class="form-text text-muted">{{__('name_help')}}</small>
        </div>
        <div class="form-group">
            {!! Form::label('email', __('Email')); !!}
            {!! Form::text('email',old('email'), ['class'=> 'form-control', 'type' => 'email', 'required'=> true]); !!}
            <small id="nameHelp" class="form-text text-muted">{{__('email_help')}}</small>
        </div>
        <div class="form-group">
            {!! Form::label('password', __('Password')); !!}
            {!! Form::password('password',old('password'), ['class'=> 'form-control', 'type' => 'password', 'required'=> true]); !!}
            <small id="nameHelp" class="form-text text-muted">{{__('pasword_help')}}</small>
        </div>
        <div class="form-group">
            {!! Form::label('password_confirmation', __('Password')); !!}
            {!! Form::password('password_confirmation',old('password_confirmation'), ['class'=> 'form-control', 'type' => 'password', 'required'=> true]); !!}
            <small id="nameHelp" class="form-text text-muted">{{__('repeat_password_help')}}</small>
        </div>
    </div>
</div>
