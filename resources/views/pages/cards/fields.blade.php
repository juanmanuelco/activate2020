
<div class="row">
    <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
        <div class="form-group">
            {!! Form::label('name', __('Title')); !!}
            {!! Form::text('name',old('name'), ['class'=> 'form-control', 'required'=> true]); !!}
        </div>

        <div class="form-group">
            {!! Form::label('subtitle', __('Subtitle')); !!}
            {!! Form::text('subtitle',old('subtitle'), ['class'=> 'form-control', 'required'=> true]); !!}
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
                <div class="form-group">
                    {!! Form::label('start', __('Start')); !!}
                    @if(isset($object))
                        : {{$object->start}}
                    @else
                        {!! Form::number('start',old('start'), ['class'=> 'form-control', 'min' => 0, 'required' => true]); !!}
                    @endif

                </div>

                <div class="form-group">
                    {!! Form::label('points', __('Points for sale')); !!}
                    {!! Form::number('points',old('points'), ['class'=> 'form-control', 'min' => 0, 'required' => true]); !!}
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    {!! Form::label('price', __('Price')); !!}
                    {!! Form::number('price',old('price'), ['class'=> 'form-control', 'min' => 0, 'step' => 0.01, 'required' => true]); !!}
                </div>

                <div class="form-group">
                    {!! Form::label('days', __('Days')); !!}
                    {!! Form::number('days',old('days'), ['class'=> 'form-control', 'min' => 0, 'required' => true]); !!}
                </div>

                <div class="form-group">
                    {!! Form::label('end', __('End')); !!}
                    @if(isset($object))
                        : {{$object->end}}
                    @else
                        {!! Form::number('end',old('end'), ['class'=> 'form-control', 'min' => 0]); !!}
                    @endif

                </div>
                <div class="form-group">
                    {!! Form::label('hidden', __('Hidden card')); !!}
                    @if(empty($object))
                        {!! Form::checkbox('hidden',old('show_in_menu')); !!}
                    @else
                        {!! Form::checkbox('hidden',old('show_in_menu'), $object->hidden ); !!}
                    @endif
                </div>

            </div>
        </div>


    </div>
    <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
        <h4>{{__('Stores')}}</h4>
        <hr>
        <div style="overflow-y: scroll; max-height: 400px" >
            <table class="table">
                <?php
                $current_stores  = [];
                    if(isset($object)){
                        $current_stores = App\Models\Card::find($object->id)->stores()->get()->pluck('id')->toArray();
                    }
                ?>
                @foreach($stores as $key => $store)
                    <tr>
                        <td><input id="check_{{$key}}" type="checkbox" name="stores[]" value="{{$key}}" {{in_array($key, $current_stores) ? 'checked' : ''}}></td>
                        <td><label for="check_{{$key}}">{{$store}}</label></td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>

    <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
        @include('includes.images')
    </div>
</div>



