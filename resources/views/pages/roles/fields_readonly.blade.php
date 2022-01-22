<div class="row">
    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
            {!! Form::label('name', __('Name')); !!}
            <div style="color: black">
                {{$object->name}}
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
            {!! Form::label('guard_name', __('guard')); !!} <i id="selected_icon"></i>
            <div style="color: black">
                {{$object->guard_name}}
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
            {!! Form::label('public', __('public')); !!} <i id="selected_icon"></i>
            <div style="color: black">
                {{$object->public? 'Público': 'Privado'}}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('is_admin', __('Is admin')); !!} <i id="selected_icon"></i>
            <div style="color: black">
                {{$object->is_admin? 'Es administrador': 'No tiene permisos de administrador'}}
            </div>
        </div>
    </div>
</div>
