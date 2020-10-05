<div class="row">
    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
            {!! Form::label('name', __('Name')); !!}
            <div style="color: black">
                {{$object->name}}
            </div>
            <small id="nameHelp" class="form-text text-muted">{{__('name_help')}}</small>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
            {!! Form::label('guard_name', __('guard')); !!} <i id="selected_icon"></i>
            <div style="color: black">
                {{$object->guard_name}}
            </div>
            <small id="nameHelp" class="form-text text-muted">{{__('guard_help')}} </small>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
            {!! Form::label('public', __('public')); !!} <i id="selected_icon"></i>
            <div style="color: black">
                {{$object->public? 'Público': 'Privado'}}
            </div>
            <small id="nameHelp" class="form-text text-muted">{{__('public_help')}} </small>
        </div>
    </div>
</div>
