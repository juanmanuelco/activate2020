
<div class="row">
    <div class="col-lg-8 col-md-6 col-sm-12 col-xs-12">
        <div class="form-group">
            {!! Form::label('name', __('Name')); !!}
            {!! Form::text('name',old('name'), ['class'=> 'form-control', 'required'=> true]); !!}
        </div>

        <div class="form-group">
            {!! Form::label('card', __('Card')); !!}
            {!! Form::select('card',$cards,null, ['class'=> 'form-control', 'required'=> true]); !!}
        </div>

    </div>
    <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
        @include('includes.images')
    </div>
</div>


