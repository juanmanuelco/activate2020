@extends('layouts.app')
@section('content')
    @include('includes.form', [
                                    'title' => 'Constructor',
                                    'description'=> 'Constructor manual de sitios web',
                                    'route'=> 'builder.insert_update',
                                   'method' => 'PUT',
                                    'html'  =>  'pages.builder.fields',
                                    'object' => $builder,
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

