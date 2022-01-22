
<div class="row">
    <div class="col-lg-8 col-md-6 col-sm-12 col-xs-12">
        <div class="form-group">
            {!! Form::label('name', __('Name')); !!}
            {!! Form::text('name',old('name'), ['class'=> 'form-control', 'required'=> true]); !!}
            <small id="nameHelp" class="form-text text-muted">{{__('name_help')}}</small>
        </div>

        <div class="form-group">
            {!! Form::label('description', __('Description')); !!}
            {!! Form::text('description',old('description'), ['class'=> 'form-control', 'required'=> true]); !!}
            <small id="nameHelp" class="form-text text-muted">{{__('description_help')}}</small>
        </div>

        <div class="form-group">
            {!! Form::label('parent', __('Parent')); !!}
            {!! Form::select('parent',$categories,null, ['class'=> 'form-control']); !!}
            <small id="nameHelp" class="form-text text-muted">{{__('parent_help')}}</small>
        </div>

        <div class="form-group">
            {!! Form::label('color', __('Color')); !!}
            {!! Form::color('color',old('color'), ['class'=> 'form-control', 'required'=> true]); !!}
        </div>

    </div>
    <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
        @include('includes.images')
    </div>
</div>

@section('new_scripts')
    <script>
        let val = false;
        let selected = document.getElementsByTagName('option');
        for(let i=0; i < selected.length; i++){
            if(selected[i].getAttribute('selected')) val= true;
        }
        if(!val)   document.getElementById('parent').selectedIndex = -1;
    </script>
@endsection

