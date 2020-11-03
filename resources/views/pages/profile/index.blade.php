@extends('layouts.app')
@section('content')

    @php
        use Carbon\CarbonImmutable;
    @endphp

    {!! Form::open(['route' => 'profile.index']) !!}
    {!! Form::model($user) !!}

   <div style="margin-top: 25px; text-align: left">
       <div class="row">
           <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
               <div class="row">
                   <div class="col-lg-4">
                       <div class="text-center">
                           <label for="image_profile" style="cursor: pointer">
                               <img src="{{empty($user->photo) ? asset('images/user.png') : $user->photo}}" class="img-thumbnail rounded" id="profile_avatar" alt="avatar" width="100%">
                           </label>
                           <input type="file" id="image_profile" style="display: none" accept="image/*">
                           <small>Miembro desde</small>
                           <p>{{CarbonImmutable::parse($user->created_at)->calendar()}}</p>
                       </div>
                   </div>
                   <div class="col-lg-8">
                       <h5>Mis roles</h5>
                       <ul>
                           @foreach($user->getRoleNames() as $role)
                               <li>{{$role}}</li>
                           @endforeach
                       </ul>
                   </div>
               </div>
               <hr>
               <div class="accordion" id="config_collapse">
                   <div class="card">
                       <div class="card-header" id="headingConfig"  data-toggle="collapse" data-target="#collapseConfig" aria-expanded="false" aria-controls="collapseConfig"  style="background-color: var(--background); cursor: pointer">
                           <h6 style="color: white">{{__('configuration')}}</h6>
                       </div>

                       <div id="collapseConfig" class="collapse" aria-labelledby="headingConfig" data-parent="#config_collapse">
                           <div class="card-body">
                               <ul class="list-group" style="margin-bottom: 25px">
                                   @foreach($configurations as $configuration)
                                       <li class="list-group-item d-flex justify-content-between align-items-center">
                                           <i class="{{$configuration['icon']}}"></i> {{$configuration['name']}}
                                           <label class="switch">
                                               {!! Form::checkbox($configuration['field'], $configuration['field'], $user[$configuration['field']], ['onchange' => "changeConfiguration(this, '". $configuration['field'] ."' )"]) !!}
                                               <span class="slider round"></span>
                                           </label>
                                       </li>
                                   @endforeach
                               </ul>
                           </div>
                       </div>
                   </div>
                   <div class="card">
                       <div class="card-header" id="activityConfig"  data-toggle="collapse" data-target="#collapseActivity" aria-expanded="false" aria-controls="collapseActivity"  style="background-color: var(--background); cursor: pointer">
                           <h6 style="color: white"> {{__('activity')}}</h6>
                       </div>

                       <div id="collapseActivity" class="collapse" aria-labelledby="headingActivity" data-parent="#config_collapse">
                           <div class="card-body">
                               <ul class="list-group" style="margin-top: 10px">
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
                   <div class="card">
                       <div class="card-header" id="aboutmeConfig"  data-toggle="collapse" data-target="#collapseAboutme" aria-expanded="false" aria-controls="collapseAboutme"  style="background-color: var(--background); cursor: pointer">
                           <h6 style="color: white"> {{__('about_me')}}</h6>
                       </div>

                       <div id="collapseAboutme" class="collapse" aria-labelledby="headingAboutme" data-parent="#config_collapse">
                           <div class="card-body">
                               <div id="about_me" style="max-height: 200px; height:200px">
                                   @if(!empty($user))
                                       {!! $user->about_me !!}
                                   @endif
                               </div>
                               <input type="hidden" id="about_me_id" name="about_me" value="{{ empty($user) ? '' : $user->about_me  }}">
                               <hr>
                           </div>
                       </div>
                   </div>
                   <div class="card">
                       <div class="card-header" id="directionConfig"  data-toggle="collapse" data-target="#collapseDirection" aria-expanded="false" aria-controls="collapseDirection"  style="background-color: var(--background); cursor: pointer">
                           <h6 style="color: white"> {{__('direction')}}</h6>
                       </div>

                       <div id="collapseDirection" class="collapse" aria-labelledby="headingDirection" data-parent="#config_collapse">
                           <div class="card-body">
                               <div class="form-group row">
                                   {!! Form::label('country', trans('country'), ['class' => 'col-sm-4 col-form-label']) !!}
                                   <div class="col-sm-8">
                                       <select class="custom-select" class="form-control form-control-sm" name="country" id="country">
                                           @foreach($countries as $country)
                                               <option value="{{$country->id}}"
                                                       @if(empty($user->country) && $country->id == 62 ) selected
                                                        @elseif ($user->country == $country->id) selected  @endif
                                               >{{$country->nicename}}</option>
                                           @endforeach
                                       </select>
                                   </div>
                               </div>
                               <div class="form-group row">
                                   {!! Form::label('state', trans('state'), ['class' => 'col-sm-4 col-form-label']) !!}
                                   <div class="col-sm-8">
                                        {!! Form::text('state', old('state'), ['class' => 'form-control form-control-sm' ]) !!}
                                   </div>
                               </div>

                               <div class="form-group row">
                                   {!! Form::label('city', trans('city'), ['class' => 'col-sm-4 col-form-label']) !!}
                                   <div class="col-sm-8">
                                       {!! Form::text('city', old('city'), ['class' => 'form-control form-control-sm' ]) !!}
                                   </div>
                               </div>

                               <div class="form-group row">
                                   {!! Form::label('address1', trans('address1'), ['class' => 'col-sm-4 col-form-label']) !!}
                                   <div class="col-sm-8">
                                       {!! Form::text('address1', old('address1'), ['class' => 'form-control form-control-sm' ]) !!}
                                   </div>
                               </div>

                               <div class="form-group row">
                                   {!! Form::label('address2', trans('address2'), ['class' => 'col-sm-4 col-form-label']) !!}
                                   <div class="col-sm-8">
                                       {!! Form::text('address2', old('address2'), ['class' => 'form-control form-control-sm' ]) !!}
                                   </div>
                               </div>

                               <div class="form-group row">
                                   {!! Form::label('postcode', trans('postcode'), ['class' => 'col-sm-4 col-form-label']) !!}
                                   <div class="col-sm-8">
                                       {!! Form::text('postcode', old('postcode'), ['class' => 'form-control form-control-sm' ]) !!}
                                   </div>
                               </div>
                               <div style="text-align: right">
                                   <button class="btn btn-primary" onclick="save_direction()" type="button">{{__('save')}}</button>
                               </div>

                           </div>
                       </div>
                   </div>
                   <div class="card">
                       <div class="card-header" id="contactConfig"  data-toggle="collapse" data-target="#collapseContact" aria-expanded="false" aria-controls="collapseContact"  style="background-color: var(--background); cursor: pointer">
                           <h6 style="color: white"> {{__('my_contact')}}</h6>
                       </div>

                       <div id="collapseContact" class="collapse" aria-labelledby="headingContact" data-parent="#config_collapse">
                           <div class="card-body">

                               <div class="form-group">
                                   {!! Form::label('email', trans('E-Mail Address')) !!}
                                   <div class="form-group input-group">
                                       {!! Form::text('email', old('email'), ['class' => 'form-control form-control-sm', 'readonly'=>'']) !!}
                                       <div class="col-sm-1">
                                           <button type="button" class="btn btn-outline-primary"><i class="fa fa-sync"></i></button >
                                       </div>
                                   </div>
                               </div>


                               <div class="form-group">
                                   {!! Form::label('phone', trans('phone')) !!}
                                   <div class="form-group input-group">
                                       {!! Form::select('code_phone', $phone_codes, null, ['class' => 'custom-select' , 'style'=>'max-width:180px', 'disabled'=>'']) !!}
                                       {!! Form::tel('phone', old('phone'), ['class' => 'form-control', 'readonly'=>'' ]) !!}
                                       <div class="col-sm-1">
                                           <button type="button" class="btn btn-outline-primary"><i class="fa fa-sync"></i></button >
                                       </div>
                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>
                   <div class="card">
                       <div class="card-header" id="passwordConfig"  data-toggle="collapse" data-target="#collapsePassword" aria-expanded="false" aria-controls="collapsePassword"  style="background-color: var(--background); cursor: pointer">
                           <h6 style="color: white"> {{__('change_password')}}</h6>
                       </div>

                       <div id="collapsePassword" class="collapse" aria-labelledby="headingPassword" data-parent="#config_collapse">
                           <div class="card-body">
                               <div class="form-group row">
                                   {!! Form::label('password', trans('Password'), ['class' => 'col-sm-4 col-form-label']) !!}
                                   <div class="col-sm-8">
                                       <input type="password" class="form-control form-control-sm" id="password" >
                                   </div>
                               </div>

                               <div class="form-group row">
                                   {!! Form::label('new_password', trans('new_password'), ['class' => 'col-sm-4 col-form-label']) !!}
                                   <div class="col-sm-8">
                                       <input type="password" class="form-control form-control-sm" minlength="8" id="new_password">
                                   </div>
                               </div>

                               <div class="form-group row">
                                   {!! Form::label('confirm_password', trans('confirm_password'), ['class' => 'col-sm-4 col-form-label']) !!}
                                   <div class="col-sm-8">
                                       <input type="password" class="form-control form-control-sm" minlength="8" id="confirm_password">
                                   </div>
                               </div>
                               <div style="text-align: right">
                                   <button type="button" class="btn btn-primary " onclick="change_password()">{{__('change_password')}}</button>
                               </div>

                           </div>
                       </div>
                   </div>
               </div>
               <hr>
           </div>
           <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12">
               <div class="row">
                   <div class="col-lg-6">
                       <h3>{{__('profile')}}</h3>
                       <div class="form-group">
                           {!! Form::label('name', trans('Name')) !!}
                           {!! Form::text('name', old('name'), ['class' => 'form-control']) !!}
                       </div>

                       <div class="form-group" style="margin-bottom: 53px">
                           {!! Form::label('birthday', trans('birth')) !!}
                           <div class="form-group input-group">
                               {!! Form::date('birthday', old('birthday'), ['class' => 'form-control']) !!}
                           </div>
                       </div>

                       <hr>
                       <h3 style="margin-top: 40px">{{__('other_data')}}</h3>

                       <div class="form-group">
                           {!! Form::label('identification', trans('identification')) !!}
                           {!! Form::text('identification', old('identification'), ['class' => 'form-control']) !!}
                       </div>

                       <div class="form-group">
                           {!! Form::label('civil_state', trans('civil_state')) !!}
                           {!! Form::select('civil_state', getCivilStates(), null, ['class' => 'custom-select' ]) !!}
                       </div>

                       <hr>

                       <button class="btn btn-primary" style="float: right">{{__('save')}}</button>
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
            document.getElementById('about_me_id').value = document.getElementById('about_me').getElementsByClassName('ql-editor')[0].innerHTML;
        });
        $("#image_profile").change(function() {  show_image_profile(this); });
        $('form input').on('keypress', function(e) {
            return e.which !== 13;
        });
    </script>
@endsection
