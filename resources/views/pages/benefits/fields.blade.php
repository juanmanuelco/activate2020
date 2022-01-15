
<div class="row">
    <div class="col-lg-8 col-md-6 col-sm-12 col-xs-12">
        <div class="form-group">
            {!! Form::label('name', __('Name')); !!}
            {!! Form::text('name',old('name'), ['class'=> 'form-control', 'required'=> true]); !!}
            <small id="nameHelp" class="form-text text-muted">{{__('name_help')}}</small>
        </div>

        <div class="form-group">
            {!! Form::label('benefit', __('Benefit')); !!}
            {!! Form::textarea('benefit',old('benefit'), ['class'=> 'form-control', 'required'=> true,  'rows' => 3]); !!}
            <small id="nameHelp" class="form-text text-muted">{{__('benefit_help')}}</small>
        </div>
        <div class="form-group">
            {!! Form::label('restriction', __('Restriction')); !!}
            {!! Form::textarea('restriction',old('restriction'), ['class'=> 'form-control',  'rows' => 3]); !!}
            <small id="nameHelp" class="form-text text-muted">{{__('restriction_help')}}</small>
        </div>

        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    {!! Form::label('store', __('Store')); !!}
                    {!! Form::select('store',$stores,null, ['class'=> 'form-control']); !!}
                    <small id="nameHelp" class="form-text text-muted">{{__('store_help')}}</small>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    {!! Form::label('unlimited', __('Unlimited')); !!}
                    @if(empty($object))
                        {!! Form::checkbox('unlimited',old('unlimited')); !!}
                    @else
                        {!! Form::checkbox('unlimited',old('unlimited'), $object->unlimited ); !!}
                    @endif
                    <small id="nameHelp" class="form-text text-muted">{{__('unlimited_help')}}</small>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    {!! Form::label('points', __('Points by use')); !!}
                    {!! Form::number('points',old('points'), ['class'=> 'form-control', 'min'=>0]); !!}
                </div>

            </div>
            <div class="col-6">
                <div class="form-group">
                    {!! Form::label('gains', __('Gains by use')); !!}
                    {!! Form::number('gains',old('gains'),['class'=> 'form-control', 'min'=>0, 'step'=>0.01]); !!}
                </div>
            </div>
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
        if(!val)   document.getElementById('store').selectedIndex = -1;
    </script>
@endsection

