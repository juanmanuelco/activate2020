
<div class="row">
    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
            {!! Form::label('name', __('Title')); !!}
            : {{$object->name}}
        </div>

        <div class="form-group">
            {!! Form::label('subtitle', __('Subtitle')); !!}
            : {{$object->subtitle}}
        </div>

        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    {!! Form::label('facebook', __('Facebook')); !!}
                    : {{$object->facebook}}
                </div>

                <div class="form-group">
                    {!! Form::label('instagram', __('Instagram')); !!}
                    : {{$object->instagram}}
                </div>
                <div class="form-group">
                    {!! Form::label('start', __('Start')); !!}
                    : {{$object->start}}
                </div>

                <div class="form-group">
                    {!! Form::label('points', __('Points for sale')); !!}
                    : {{$object->points}}
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    {!! Form::label('price', __('Price')); !!}
                    : ${{number_format($card->price, 2, '.',',')}}
                </div>

                <div class="form-group">
                    {!! Form::label('days', __('Days')); !!}
                    : {{$object->days}}
                </div>

                <div class="form-group">
                    {!! Form::label('end', __('End')); !!}
                    : {{$object->end}}


                </div>
                <div class="form-group">
                    {{$object->hidden ? __('Is a hidden card'): __('Is a puplic card')}}
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
                        <td><input type="checkbox" disabled name="stores[]" value="{{$key}}" {{in_array($key, $current_stores) ? 'checked' : ''}}></td>
                        <td>{{$store}}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
        @if(!empty($object->getImage()))
            <img width="400px" src="<?php echo  '/images/system/' . $object->getImage()->id . '.' . $object->getImage()->extension ?>" alt="<?php echo $object->getImage()->name ?>">
        @endif
    </div>
</div>
