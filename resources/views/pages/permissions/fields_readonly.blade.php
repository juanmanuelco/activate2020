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
            {!! Form::label('group', __('group')); !!} <i id="selected_icon"></i>
            <div style="color: black">
                @if(!empty($object->group))
                    {{\App\Models\Group::find($object->group)->name}}
                @endif
            </div>

        </div>

        <div class="form-group">
            {!! Form::label('show_in_menu', __('Show in menu')); !!} <i id="selected_icon"></i>
            <div style="color: black">
                {{$object->show_in_menu? 'Mostrar en menú': 'No mostrar en menu'}}
            </div>
        </div>

    </div>
    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
            {!! Form::label('detail', __('detail')); !!}
            <div style="color: black">
                {{$object->detail}}
            </div>

        </div>
    </div>
</div>
