
<div class="row">
    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
            {!! Form::label('name', __('Name')); !!}
            {!! Form::text('name',old('name'), ['class'=> 'form-control', 'required'=> true]); !!}
            <small id="nameHelp" class="form-text text-muted">{{__('name_help')}}</small>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
            {!! Form::label('guard_name', __('guard')); !!} <i id="selected_icon"></i>
            {!! Form::text('guard_name',old('guard'), ['class'=> 'form-control',  'required'=>true]); !!}
            <small id="nameHelp" class="form-text text-muted">{{__('guard_help')}}</small>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
            {!! Form::label('public', __('public')); !!} <i id="selected_icon"></i>
            <div style="color: black">
                @if(empty($object))
                    {!! Form::checkbox('public',old('public')); !!}
                @else
                    {!! Form::checkbox('public',old('public'), $object->public ); !!}
                @endif

            </div>
            <small id="nameHelp" class="form-text text-muted">{{__('public_help')}} </small>
        </div>
    </div>
</div>
