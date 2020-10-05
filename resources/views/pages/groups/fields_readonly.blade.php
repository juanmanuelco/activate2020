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
            {!! Form::label('icon', __('icon')); !!} <i id="selected_icon"></i>
            <div style="color: black">
            {{$object->icon}}
            </div>
            <small id="nameHelp" class="form-text text-muted">{{__('icon_help')}} <a href="https://fontawesome.com/icons?d=gallery" target="_blank">Font awesome</a></small>
        </div>
    </div>
</div>
