@extends('layouts.app')
@section('content')
    @include('includes.search')
    <div class="table table-responsive" style ="text-align: left">
        <table class="table">
            <thead class="thead-dark">
            <tr>
                <th>{{__('id')}}</th>
                <th>{{__('actions')}}</th>
                <th>{{__('Name')}}</th>
                <th>{{__('Description')}}</th>
                <th>{{__('Parent')}}</th>
                <th>{{__('Image')}}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($categories as $category)
                <tr>
                    <td> {{$category->id}} </td>
                    <td>
                        @include('includes.table_actions', ['identity' => $category->id])
                    </td>
                    <td> {{$category->name}} </td>
                    <td>
                        {{$category->description}}
                    </td>
                    <td>
                        {{$category->parent() != null ? $category->parent()->name : ""}}
                    </td>
                    <td>
                        @if(!empty($category->getImage()))
                            <img width="100px" src="<?php echo  '/images/system/' . $category->getImage()->id . '.' . $category->getImage()->extension ?>" alt="<?php echo $category->getImage()->name ?>">
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div style="width: 100%;">
        {{ $categories->links() }}
    </div>
@endsection
