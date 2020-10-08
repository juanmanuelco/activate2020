@extends('layouts.app')
@section('custom_styles')
    <link rel="stylesheet" href="{{asset('css/home.css')}}">
@endsection
@section('content')
    @php
        $active_roles = \Illuminate\Support\Facades\Auth::user()->getRoleNames();
        $other_roles = \Spatie\Permission\Models\Role::whereNotIn('name', $active_roles)->where('public', true)->get();
    @endphp
   @if(count($other_roles) > 0)
        <div class="social-box">

            <div class="container">
                <h1 class="center" style="margin-top: 30px;">{{__('how_to_use')}}</h1>

                <div class="row">
                    @foreach($other_roles as $role)
                        <div class="col-lg-4 col-xs-12 text-center" style="margin-top: 15px">
                            <div class="box">
                                <i class="{{$role->icon}} fa-3x" aria-hidden="true"></i>
                                <div class="box-title">
                                    <h3>{{$role->name}}</h3>
                                </div>
                                <div class="box-text">
                                    {!! $role->description !!}
                                </div>
                                <div class="box-btn">
                                    <a href="{{route('role.apply', ['role' => $role->id])}}">{{__('apply')}}</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
@endsection
