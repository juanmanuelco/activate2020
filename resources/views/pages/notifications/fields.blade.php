<div class="row">
    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
            {!! Form::label('detail', __('detail')); !!}
            {!! Form::textarea('detail',old('detail'), ['class'=> 'form-control', 'required'=> true]); !!}
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
    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
            {!! Form::label('expiration', __('expiration')); !!}
            {!! Form::datetimeLocal('expiration',old('expiration'), ['class'=> 'form-control input_datetime', 'required'=> true]); !!}
        </div>
    </div>
</div>


@section('new_scripts')
    <script>
        $('#icon').change(()=>{
            document.getElementById('selected_icon').setAttribute('class', document.getElementById('icon').value)
        });
    </script>
@endsection
