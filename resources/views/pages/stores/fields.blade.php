
<div class="row">
    <div class="col-lg-8 col-md-6 col-sm-12 col-xs-12">
        <div class="form-group">
            {!! Form::label('name', __('Name')); !!}
            {!! Form::text('name',old('name'), ['class'=> 'form-control', 'required'=> true]); !!}
            <small id="nameHelp" class="form-text text-muted">{{__('name_help')}}</small>
        </div>

        <div class="form-group">
            {!! Form::label('description', __('Description')); !!}
            {!! Form::textarea('description',old('description'), ['class'=> 'form-control', 'required'=> true, 'rows' => 3]); !!}
            <small id="nameHelp" class="form-text text-muted">{{__('description_help')}}</small>
        </div>

        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    {!! Form::label('facebook', __('Facebook')); !!}
                    {!! Form::text('facebook',old('facebook'), ['class'=> 'form-control']); !!}
                </div>

                <div class="form-group">
                    {!! Form::label('instagram', __('Instagram')); !!}
                    {!! Form::text('instagram',old('instagram'), ['class'=> 'form-control']); !!}
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    {!! Form::label('web_page', __('Web page')); !!}
                    {!! Form::text('web_page',old('web_page'), ['class'=> 'form-control']); !!}
                </div>

                <div class="form-group">
                    {!! Form::label('phone', __('Phone')); !!}
                    {!! Form::text('phone',old('phone'), ['class'=> 'form-control', 'rel' =>'tel']); !!}
                </div>
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('category', __('Category')); !!}
            {!! Form::select('category',$categories,null, ['class'=> 'form-control']); !!}
            <small id="nameHelp" class="form-text text-muted">{{__('category_help')}}</small>
        </div>

        <div class="form-group">
            {!! Form::label('owner', __('Owner')); !!}
            {!! Form::select('owner',$owners,null, ['class'=> 'form-control']); !!}
            <small id="nameHelp" class="form-text text-muted">{{__('owner_help')}}</small>
        </div>



        <div class="form-group">
            {!! Form::label('schedule', __('Schedule')); !!}
            {!! Form::textarea('schedule',old('schedule'), ['class'=> 'form-control', 'rows' => 3]); !!}
            <small id="nameHelp" class="form-text text-muted">{{__('schedule_help')}}</small>
        </div>


    </div>
    <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
        @include('includes.images')
    </div>
</div>

@section('new_scripts')
    <script>
        let val = false;
        let selected = document.getElementById('owner').getElementsByTagName('option');
        for(let i=0; i < selected.length; i++){
            if(selected[i].getAttribute('selected')) val= true;
        }
        if(!val)   document.getElementById('owner').selectedIndex = -1;


        val = false;
        selected = document.getElementById('category').getElementsByTagName('option');
        console.log(selected)
        for(let i=0; i < selected.length; i++){
            if(selected[i].getAttribute('selected')) val= true;
        }
        if(!val)   document.getElementById('category').selectedIndex = -1;


    </script>
@endsection

