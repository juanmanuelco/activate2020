@extends('layouts.app')
@section('content')
    @include('includes.form', [
                                    'title' => 'Constructor',
                                    'description'=> 'Constructor manual de sitios web',
                                    'route'=> 'builder.insert_post',
                                    'method' => 'POST',
                                    'html'  =>  'pages.builder.fields',
                                    'object' => null,
                                    'files'     =>  false
                               ])
    <div class="col-12">
        <hr>
        <iframe id="code"></iframe>
    </div>
@endsection


@section('new_scripts')
    <script>
        compile();
    </script>
@endsection

