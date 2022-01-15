
<div class="row">
    <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
        <div class="form-group">
            {!! Form::label('card', __('Card')); !!}
            {!! Form::select('card',$cards,null, ['class'=> 'form-control', 'required'=> true]); !!}
        </div>

        <div class="form-group">
            {!! Form::label('seller', __('Seller')); !!}
            {!! Form::select('seller',$sellers,null, ['class'=> 'form-control']); !!}
        </div>

        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    {!! Form::label('start', __('Start')); !!}
                    {!! Form::number('start',old('start'), ['class'=> 'form-control', 'min' => 0, 'required' => true]); !!}
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    {!! Form::label('end', __('End')); !!}
                    {!! Form::number('end',old('end'), ['class'=> 'form-control', 'min' => 0, 'required' => true]); !!}
                </div>
            </div>
        </div>

    </div>
</div>



