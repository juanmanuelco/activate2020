
<div class="row">
    <div class="col-lg-8 col-md-6 col-sm-12 col-xs-12">
        <div class="form-group">
            {!! Form::label('name', __('Nickname')); !!}
            {!! Form::text('name',old('name'), ['class'=> 'form-control', 'required'=> true]); !!}
            <small id="nameHelp" class="form-text text-muted">{{__('name_help')}}</small>
        </div>

        <div class="form-group">
            {!! Form::label('user', __('User')); !!}
            @if(isset($object))
                : {{$object->getUser()->name}}
            @else
                {!! Form::select('user',$users,null, ['class'=> 'form-control', 'required' => true]); !!}
            @endif
        </div>


        <div class="form-group">
            {!! Form::label('superior', __('Superior')); !!}
            @if(isset($object))
                : {{(isset($object->superior) ? $object->getSuperior()->name : __('None'))}}
            @else
                {!! Form::select('superior',$superiors,null, ['class'=> 'form-control']); !!}
            @endif

        </div>

        <div class="form-group">
            {!! Form::label('commission', __('Comission')); !!}
            {!! Form::number('commission',old('commission'), ['class'=> 'form-control', 'required'=> true, 'step' => 0.01, 'min'=>0, 'max' => 99.99]); !!}
        </div>

    </div>

</div>

@section('new_scripts')
    @if(!isset($object))
        <script>
            let val = false;
            let selected = document.getElementById('superior').getElementsByTagName('option');
            for(let i=0; i < selected.length; i++){
                if(selected[i].getAttribute('selected')) val= true;
            }
            if(!val)   document.getElementById('superior').selectedIndex = -1;
        </script>
    @endif
@endsection

