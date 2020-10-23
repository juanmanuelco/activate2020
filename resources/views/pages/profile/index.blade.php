@extends('layouts.app')
@section('content')

    {!! Form::open(['route' => 'profile.index']) !!}
    {!! Form::model($user) !!}

   <div style="margin-top: 25px; text-align: left">
       <div class="row">
           <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
               <div class="row">
                   <div class="col-lg-4">
                       <div class="text-center">
                           <label for="image_profile" style="cursor: pointer">
                               <img src="{{empty($user->photo) ? asset('images/user.png') : $user->photo}}" class="img-thumbnail rounded" alt="avatar" width="100%">
                           </label>
                           <input type="file" id="image_profile" style="display: none">
                       </div>
                   </div>
                   <div class="col-lg-8">
                       <ul>
                           @foreach($user->getRoleNames() as $role)
                               <li>{{$role}}</li>
                           @endforeach
                       </ul>
                   </div>
               </div>
               <hr>
               <ul class="list-group" style="margin-bottom: 25px">
                   <li class="list-group-item list-group-item-action active" style="background-color: var(--background)">
                       {{__('configuration')}}
                   </li>
                   @foreach($configurations as $configuration)
                       <li class="list-group-item d-flex justify-content-between align-items-center">
                           <i class="{{$configuration['icon']}}"></i> {{$configuration['name']}}
                           <label class="switch">
                               {!! Form::checkbox($configuration['field'], $configuration['field'], $user[$configuration['field']]) !!}
                               <span class="slider round"></span>
                           </label>
                       </li>
                   @endforeach
               </ul>
           </div>
           <div class="col-lg-9 col-md-8 col-sm-6 col-xs-12">
               <div class="row">
                   <div class="col-lg-6">
                       <h3>{{__('profile')}}</h3>
                       <div class="form-group">
                           {!! Form::label('name', trans('Name')) !!}
                           {!! Form::text('name', old('name'), ['class' => 'form-control']) !!}
                       </div>

                       <div class="form-group">
                           {!! Form::label('email', trans('E-Mail Address')) !!}
                           {!! Form::text('email', old('email'), ['class' => 'form-control', 'readonly'=>'']) !!}
                       </div>

                       <div class="form-group">
                           {!! Form::label('phone', trans('phone')) !!}
                           <div class="form-group input-group">
                               {!! Form::select('code_phone', $phone_codes, null, ['class' => 'custom-select' , 'style'=>'max-width:180px', 'disabled'=>'']) !!}
                               {!! Form::tel('phone', old('phone'), ['class' => 'form-control', 'readonly'=>'' ]) !!}
                           </div>
                       </div>

                       <div class="form-group">
                           {!! Form::label('birthday', trans('birth')) !!}
                           <div class="form-group input-group">
                               {!! Form::date('birthday', old('birthday'), ['class' => 'form-control']) !!}
                           </div>
                       </div>
                       <h3 style="margin-top: 15px">{{__('other_data')}}</h3>
                       <hr>

                       <div class="row">
                           <div class="col-lg-4">
                               {!! Form::label('country', trans('country')) !!}
                               <div class="form-group input-group">
                                   <select class="custom-select" id="">
                                       @foreach($countries as $country)
                                           <option value="{{$country->id}}"
                                           @if(empty($user->country) && $country->id == 62 ) selected @endif
                                           >{{$country->nicename}}</option>
                                       @endforeach
                                   </select>
                               </div>
                           </div>
                           <div class="col-lg-4">
                               {!! Form::label('state', trans('state')) !!}
                               <div class="form-group input-group">
                                   {!! Form::text('state', old('state'), ['class' => 'form-control' ]) !!}
                               </div>
                           </div>
                           <div class="col-lg-4">
                               {!! Form::label('city', trans('city')) !!}
                               <div class="form-group input-group">
                                   {!! Form::text('city', old('city'), ['class' => 'form-control' ]) !!}
                               </div>
                           </div>

                           <div class="col-lg-4">
                               {!! Form::label('addres1', trans('addres1')) !!}
                               <div class="form-group input-group">
                                   {!! Form::text('addres1', old('addres1'), ['class' => 'form-control' ]) !!}
                               </div>
                           </div>
                           <div class="col-lg-4">
                               {!! Form::label('addres2', trans('addres2')) !!}
                               <div class="form-group input-group">
                                   {!! Form::text('addres2', old('addres2'), ['class' => 'form-control' ]) !!}
                               </div>
                           </div>
                           <div class="col-lg-4">
                               {!! Form::label('postcode', trans('postcode')) !!}
                               <div class="form-group input-group">
                                   {!! Form::text('postcode', old('postcode'), ['class' => 'form-control' ]) !!}
                               </div>
                           </div>
                           <div class="col-lg-4">
                               <div class="form-group">
                                   {!! Form::label('postcode', trans('postcode')) !!}
                                   {!! Form::text('postcode', old('postcode'), ['class' => 'form-control']) !!}
                               </div>
                           </div>
                           <div class="col-lg-4">
                               <div class="form-group">
                                   {!! Form::label('identification', trans('identification')) !!}
                                   {!! Form::text('identification', old('identification'), ['class' => 'form-control']) !!}
                               </div>
                           </div>
                           <div class="col-lg-4">
                               <div class="form-group">
                                   {!! Form::label('civil_state', trans('civil_state')) !!}
                                   {!! Form::select('civil_state', getCivilStates(), null, ['class' => 'custom-select' ]) !!}
                               </div>
                           </div>
                           <div style="width: 100%; padding-right: 15px; margin-bottom: 25px">
                               <button class="btn btn-primary" style="float: right">{{__('save')}}</button>
                           </div>
                       </div>
                   </div>
                   <div class="col-lg-6">
                       <h3>{{__('about_me')}}</h3>
                       <div id="about_me" style="max-height: 200px; display: block;">
                           @if(!empty($user))
                               {!! $user->about_me !!}
                           @endif
                       </div>
                       <input type="hidden" id="about_me_id" name="about_me" value="{{ empty($user) ? '' : $user->about_me  }}">
                       <hr>
                       <ul class="list-group" style="margin-top: 10px">
                           <li class="list-group-item list-group-item-action active" style="background-color: var(--background)">
                               {{__('activity')}}
                           </li>
                           @foreach($activities as $activity)
                               <li class="list-group-item d-flex justify-content-between align-items-center">
                                   {{$activity['name']}}
                                   <span class="badge badge-primary badge-pill" style="background-color: var(--background)">{{$activity['count']}}</span>
                               </li>
                           @endforeach
                       </ul>
                   </div>
               </div>
           </div>
       </div>
   </div>
    {{ Form::close() }}
@endsection

@section('new_scripts')
    <script>
        let quill = new Quill('#about_me', {
            theme: 'snow',
            modules: {
                toolbar: quill_toolbar
            }
        });
        quill.on('editor-change', function(eventName, ...args) {
            document.getElementById('about_me_id').value = document.getElementById('description').getElementsByClassName('ql-editor')[0].innerHTML;
        });
    </script>
@endsection
