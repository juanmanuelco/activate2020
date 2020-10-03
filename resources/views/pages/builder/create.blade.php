@extends('layouts.app')
@section('content')

    @if(Illuminate\Support\Facades\Route::currentRouteName() == 'builder.create')
    <div class="row text-white" style="background-color: black; padding: 10px">
        <div class="col-lg-1">{{__('Name')}}</div>
        <div class="col-lg-3">
            <input type="text" id="builder_name" name="name" class="form-control">
        </div>
        <div class="col-lg-1">{{__('slug') }}</div>
        <div class="col-lg-3">
            <input type="text" id="builder_slug" name="slug" class="form-control">
        </div>
            <div class="col-lg-1">
                <button type="button" id="load_builder" class="btn-light btn">{{__('load')}}</button>
            </div>
    </div>
    @else
        <div class="row text-white" style="background-color: black; padding: 10px">
            <div class="col-lg-1">{{__('Name')}}</div>
            <div class="col-lg-3">
                {{$builder->name}}
            </div>
            <div class="col-lg-1">{{__('slug') }}</div>
            <div class="col-lg-3">
               {{$builder->slug}}
            </div>
        </div>
    @endif
    <link rel="stylesheet" href="{{asset('css/toastr.css')}}">
    <link rel="stylesheet" href="{{asset('css/grape.css')}}">
    <link rel="stylesheet" href="{{asset('css/grapesjs-preset-webpage.css')}}">
    <link rel="stylesheet" href="{{asset('css/tooltip.css')}}">
    <link rel="stylesheet" href="{{asset('css/grapesjs-plugin-filestack.css')}}">
    <link rel="stylesheet" href="{{asset('css/demos.css')}}">
    <link href="{{asset('css/grapick.css')}}" rel="stylesheet">
    <style type="text/css">html { -ms-touch-action: none; }</style>
    <link href="{{asset('css/tui-color-picker.css')}}" rel="stylesheet">
    <link href="{{asset('css/tui-image-editor.css')}}" rel="stylesheet">
    <script src="{{asset('vendor/grape/fabric.js')}}"></script>
    <script src="{{asset('vendor/grape/monetization.js')}}"></script>
    <script src="{{asset('data/tui-code-snippet.txt')}}"></script>
    <div id="_bsa_srv-CK7I62QJ_0"></div>
    <script src="{{asset('vendor/grape/tui-color-picker.js')}}"></script>
    <script src="{{asset('data/tui-image-editor.txt')}}"></script>

    @if(Illuminate\Support\Facades\Route::currentRouteName() == 'builder.create')
        <style>
            #builder_panel{
                display: none;
            }
        </style>
    @endif

   <div id="builder_panel">
       <div class="panel__top">
           <div class="panel__basic-actions"></div>
           <div class="panel__devices"></div>
           <div class="panel__switcher"></div>
       </div>
       <div class="editor-row">
           <div class="editor-canvas">
               <div id="gjs"></div>
           </div>
           <div class="panel__right">
               <div class="layers-container"></div>
               <div class="styles-container"></div>
               <div class="traits-container"></div>
           </div>
       </div>
       <div id="blocks"></div>
   </div>
    <script src="{{asset('vendor/jquery/jquery.js')}}"></script>
    <script src="{{asset('vendor/grape/toastr.js')}}"></script>
    <script src="{{asset('vendor/grape/grapeJs.js')}}"></script>
    <script src="{{asset("vendor/grape/grapesjs-preset-webpage.js")}}"></script>
    <script src="{{asset("vendor/grape/grapesjs-lory-slider.js")}}"></script>
    <script src="{{asset("vendor/grape/grapesjs-tabs.js")}}"></script>
    <script src="{{asset("vendor/grape/grapesjs-custom-code.js")}}"></script>
    <script src="{{asset("vendor/grape/grapesjs-touch.js")}}"></script>
    <script src="{{asset("vendor/grape/grapesjs-parser-postcss.js")}}"></script>
    <script src="{{asset("vendor/grape/grapesjs-tooltip.js")}}"></script>
    <script src="{{asset("vendor/grape/grapesjs-tui-image-editor.js")}}"></script>
    <script src="{{asset("vendor/grape/grapesjs-typed.js")}}"></script>
    <script src="{{asset("vendor/grape/grapesjs-style-bg.js")}}"></script>
    @include('pages.builder.script')
@endsection
