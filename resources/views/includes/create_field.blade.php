<div class="row">
    @foreach($fields as $field)
        @switch($field['type'])
            @case('TEXT')
                <div class="{{$field['width']}}">
                    <div class="form-group">
                        {!! Form::label($field['name'], $field['label']); !!}
                        {!! Form::text($field['name'], old($field['name']), $field['parameters']); !!}
                        @if(!empty($field['helper']))
                            <small id="{{$field['name']}}_helper" class="form-text text-muted">{{ $field['helper'] }}</small>
                        @endif
                    </div>
                </div>
            @break
            @case('TEXTAREA')
                <div class="{{$field['width']}}">
                    <div class="form-group">
                        {!! Form::label($field['name'], $field['label']); !!}
                        <div id="{{$field['id']}}">
                            @if(!empty($field['object']))
                                {!! $field['object'] !!}
                            @endif
                        </div>
                        <input type="hidden" id="desc_{{$field['name']}}" name="{{$field['name']}}" value="{{ empty($field['object']) ? '' : $field['object']  }}">
                        @if(!empty($field['helper']))
                            <small id="{{$field['name']}}_helper" class="form-text text-muted">{{ $field['helper'] }}</small>
                        @endif
                    </div>
                </div>
            @break
            @case('CHECKBOX')
                <div class="{{$field['width']}}">
                    <div class="form-group">
                        {!! Form::label($field['name'], $field['label']); !!}
                        @if(empty($field['object']))
                            {!! Form::checkbox($field['name'],old($field['name'])); !!}
                        @else
                            {!! Form::checkbox($field['name'],old($field['name']), $field['object'] ); !!}
                        @endif
                    </div>
                </div>
            @break
            @case('NUMBER')
                <div class="{{$field['width']}}">
                    <div class="form-group">
                        {!! Form::label($field['name'], $field['label']); !!}
                        {!! Form::number($field['name'], old($field['name']), $field['parameters']); !!}
                        @if(!empty($field['helper']))
                            <small id="{{$field['name']}}_helper" class="form-text text-muted">{{ $field['helper'] }}</small>
                        @endif
                    </div>
                </div>
            @break
            @case('COLOR')
            <div class="{{$field['width']}}">
                <div class="form-group">
                    {!! Form::label($field['name'], $field['label']); !!}
                    {!! Form::color($field['name'], old($field['name']), $field['parameters']); !!}
                    @if(!empty($field['helper']))
                        <small id="{{$field['name']}}_helper" class="form-text text-muted">{{ $field['helper'] }}</small>
                    @endif
                </div>
            </div>
            @break
            @case('OBJECT')
            <div class="{{$field['width']}}">
                <div class="form-group">
                   <div>
                       <div style="float: left">
                           {!! Form::label($field['name'], $field['label']); !!}
                       </div>
                       <div style="float: right">
                           <a href="#" style="cursor: pointer">
                               <i class="fa fa-edit"></i>
                               {{__('Change')}}
                           </a>
                       </div>
                   </div>
                   <table class="table">
                       <tr>
                           <td>
                               @if(isset($field['object']))
                                   {{$field['object']->id}}
                               @endif
                           </td>
                           @if(isset($field['object']) && !empty($field['image']))
                               <td>
                                   <img src="{{$field['image']->permalink}}" alt="{{$field['image']->name}}" height="100px">
                               </td>
                           @endif
                           <td>
                               @if(isset($field['object']))
                                    {{$field['object']->name}}
                               @endif
                           </td>
                       </tr>
                   </table>
                </div>
            </div>
            @break
        @endswitch
    @endforeach
</div>
