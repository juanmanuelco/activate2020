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
            <small id="" class="form-text text-muted">{{__('guard_help')}}</small>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
            {!! Form::label('group', __('group')); !!}
            {!! Form::select('group',$groups,null, ['class'=> 'form-control']); !!}
            <small id="" class="form-text text-muted">{{__('group_help')}}</small>
        </div>
    </div>

    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
            {!! Form::label('detail', __('detail')); !!}
            {!! Form::text('detail',old('detail'), ['class'=> 'form-control', 'required'=> true]); !!}
            <small id="" class="form-text text-muted">{{__('detail_help')}}</small>
        </div>
    </div>
</div>

@section('new_scripts')
    <script>
        let val = false;
        let selected = document.getElementsByTagName('option');
        for(let i=0; i < selected.length; i++){
            if(selected[i].getAttribute('selected')) val= true;
        }
        if(!val)   document.getElementById('group').selectedIndex = -1;
    </script>
@endsection
