
<div class="row">
    <div class="col-lg-8 col-md-6 col-sm-12 col-xs-12">
        <div class="form-group">
            {!! Form::label('name', __('Name')); !!}
            {!! Form::text('name',old('name'), ['class'=> 'form-control', 'required'=> true]); !!}
            <small id="nameHelp" class="form-text text-muted">{{__('name_help')}}</small>
        </div>

        <div class="form-group">
            {!! Form::label('benefit', __('Benefits')); !!}
            <div id="benefit">
                @if(!empty($benefit))
                    {!! $benefit->benefit !!}
                @endif
            </div>
            <input type="hidden" id="desc_benefit" name="benefit" value="{{ empty($benefit) ? '' : $benefit->benefit  }}">


        </div>
        <div class="form-group">
            {!! Form::label('restriction', __('Restrictions')); !!}
            <div id="restriction">
                @if(!empty($benefit))
                    {!! $benefit->restriction !!}
                @endif
            </div>
            <input type="hidden" id="desc_restriction" name="restriction" value="{{ empty($benefit) ? '' : $benefit->restriction  }}">



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
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    {!! Form::label('points', __('Points by use')); !!}
                    {!! Form::number('points',old('points'), ['class'=> 'form-control', 'min'=>0, 'max' => 10]); !!}
                </div>

            </div>
            <div class="col-6">
                <div class="form-group">
                    {!! Form::label('gains', __('Gains by use')); !!}
                    {!! Form::number('gains',old('gains'),['class'=> 'form-control', 'min'=>0, 'step'=>0.01, 'max' => 1000]); !!}
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
        let quill = new Quill('#benefit', {
            theme: 'snow',
            modules: {
                toolbar: quill_toolbar
            }
        });
        quill.on('editor-change', function(eventName, ...args) {
            document.getElementById('desc_benefit').value = document.getElementById('benefit').getElementsByClassName('ql-editor')[0].innerHTML;
            if(document.getElementById('desc_benefit').value == '<p><br></p> '){
                document.getElementById('desc_benefit').value = '' ;
            }
        });

        let quill_r = new Quill('#restriction', {
            theme: 'snow',
            modules: {
                toolbar: quill_toolbar
            }
        });
        quill_r.on('editor-change', function(eventName, ...args) {
            document.getElementById('desc_restriction').value = document.getElementById('restriction').getElementsByClassName('ql-editor')[0].innerHTML;
            if(document.getElementById('desc_restriction').value == '<p><br></p> '){
                document.getElementById('desc_restriction').value = '' ;
            }
        });
    </script>


    <script>
        let val = false;
        let selected = document.getElementsByTagName('option');
        for(let i=0; i < selected.length; i++){
            if(selected[i].getAttribute('selected')) val= true;
        }
        if(!val)   document.getElementById('store').selectedIndex = -1;
    </script>
@endsection

