@extends('layouts.app')
@section('content')
    @php
        use Carbon\CarbonImmutable;
    @endphp
    @include('includes.search')
    <div class="" style ="text-align: left; ">
        <div class="row">
            @foreach($audits as $audit)
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <div class="card"  style="margin-bottom: 10px">
                        <div class="card-body">
                            <p><strong>{{__('id')}}:</strong> {{$audit->id}}</p>
                            <p><strong>{{__('description')}}:</strong> {{$audit->description}}</p>
                            <p><strong>{{__('object')}}:</strong> {{$audit->subject_type}}</p>
                            <p><strong>{{__('causer')}}:</strong> {{\App\Models\User::find($audit->causer_id)->name}}</p>
                            <p><strong>{{__('date')}}:</strong> {{CarbonImmutable::parse($audit->created_at)->calendar()}}</p>
                            <p>
                                <a data-toggle="collapse" href="#collapseProperties{{$audit->id}}" role="button" aria-expanded="false" >
                                    <strong>{{__('properties')}}:</strong>
                                </a>

                            </p>
                            <div class="collapse" id="collapseProperties{{$audit->id}}">
                                <ul>
                                    @foreach(json_decode($audit->properties)->attributes as $key => $value)
                                        <li>
                                            <p><strong>{{ucfirst($key)}}</strong> :
                                                @if($key === 'created_at' || $key==='updated_at' || $key == 'deleted_at')
                                                    {{CarbonImmutable::parse($value)->calendar()}}
                                                @elseif($key === 'icon')
                                                    <i class="{{$value}}"></i>
                                                @elseif($key === 'image')
                                                    @php
                                                        $image = !empty($value) ?  \App\Models\ImageFile::find($value)->extension : '';
                                                    @endphp
                                                    <img src="{{asset("images/system/$value.$image")}}" alt="" width="75px">
                                                @else
                                                    {{$value}}
                                                @endif
                                            </p>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div style="width: 100%;">
        {{ $audits->links() }}
    </div>
@endsection
