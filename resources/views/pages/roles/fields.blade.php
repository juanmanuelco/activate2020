
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
    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
            {!! Form::label('icon', __('icon')); !!} <i id="selected_icon"></i>
            {!! Form::text('icon',old('icon'), ['class'=> 'form-control', 'list'=>'icons', 'required'=>true]); !!}
            <small id="nameHelp" class="form-text text-muted">{{__('icon_help')}} <a href="https://fontawesome.com/icons?d=gallery" target="_blank">Font awesome</a></small>
            <datalist id="icons">
                @foreach(\App\Models\Icon::pluck('name') as $icon)
                    <option value="{{$icon}}">{{$icon}}</option>
                @endforeach
            </datalist>
        </div>
    </div>
    <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
        <div id="description">
            @if(!empty($role))
                {!! $role->description !!}
            @endif
        </div>
    </div>
    <input type="hidden" id="desc_id" name="description" value="{{ empty($role) ? '' : $role->description  }}">
</div>

@section('new_scripts')
    <script>
        let quill = new Quill('#description', {
            theme: 'snow',
            modules: {
                toolbar: quill_toolbar
            }
        });
        quill.on('editor-change', function(eventName, ...args) {
            document.getElementById('desc_id').value = document.getElementById('description').getElementsByClassName('ql-editor')[0].innerHTML;
        });
    </script>
@endsection
