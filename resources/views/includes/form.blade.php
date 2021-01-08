@include('includes.search')
<div>
    <h1>{{$title}}</h1>
    <p>{{$description}}</p>
    <hr>
    @if(empty($object))
        {!! Form::open(['route' => $route, 'files' => $files]) !!}
    @else
        {!! Form::model($object, ['route' => [$route, $object->id], 'method' => $method, 'files' => $files]) !!}
    @endif
    @include($html)
    <div style="text-align: right; margin-top: 50px">
        {!! Form::submit(__('save'), ['class' => 'btn btn-primary']); !!}
    </div>
</div>
