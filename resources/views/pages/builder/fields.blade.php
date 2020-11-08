<div class="row">
    {!! Form::hidden('id',old('id'), []); !!}
    <div class="col-lg-2">
        <div class="form-group">
            {!! Form::label('name', __('name')); !!}
            {!! Form::text('name',old('name'), ['class'=> 'form-control', 'required'=>true]); !!}
        </div>
    </div>

    <div class="col-lg-2">
        <div class="form-group">
            {!! Form::label('slug', __('slug')); !!}
            {!! Form::text('slug',old('slug'), ['class'=> 'form-control', 'required'=>true]); !!}
        </div>
    </div>

    <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
        <div class="form-group">
            {!! Form::label('option', __('option')); !!}
            {!! Form::select('option',[
                '0' => 'Otro',
                'index' => 'Index',
                'login' => 'Login',
                'register' => 'Registro',
                'reset'    =>   'Recuperación de cuenta'
            ],null, ['class'=> 'form-control']); !!}
        </div>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
        <div class="form-group">
            {!! Form::label('active', __('active')); !!}
            {!! Form::checkbox('active',old('active'),null, ['class'=> 'form-control']); !!}
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <div class="form-group">
            {!! Form::label('preview', __('preview')); !!}
            <input class="form-control" type="range" min="20" max="100" step="1" value="100" onchange="changeZoom('code', this)">
        </div>
    </div>
    <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12">
       <div class="form-group">
           {!! Form::label('gjs-html', __('gjs-html')); !!}
           {!! Form::textarea('gjs-html',old('gjs-html'), ['class'=> 'form-control', 'required'=>true, 'cols'=>30, 'rows' => 10]); !!}
       </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <div class="form-group">
        {!! Form::label('gjs-css', __('gjs-css')); !!}
        {!! Form::textarea('gjs-css',old('gjs-css'), ['class'=> 'form-control', 'required'=>true, 'cols'=>30, 'rows' => 10]); !!}
        </div>
    </div>
</div>
<style>
    iframe {
        bottom: 0;
        position: relative;
        width: 100%;
        height: 800px;
        max-height: 1000px;
    }
</style>
