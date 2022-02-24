
<?php
$fields = [
    [
        'name' => 'name',
        'parameters' => ['class'=> 'form-control', 'required'=> true],
        'helper' => null,
        'label' => __('Name'),
        'type' => 'TEXT',
        'id' => 'name',
        'width' => 'col-lg-8 col-md-6 col-sm-12 col-xs-12'
    ],
    [
        'name' => 'description',
        'helper' => null,
        'label' => __('Description'),
        'object' => !empty($category) ? $category->description : null,
        'type' => 'TEXTAREA',
        'id' => 'description',
        'width' => 'col-lg-8 col-md-6 col-sm-12 col-xs-12'
    ],
    [
        'name' => 'color',
        'helper' => null,
        'parameters' => ['class'=> 'form-control', 'required'=> true],
        'label' => __('Color'),
        'type' => 'COLOR',
        'id' => 'color',
        'width' => 'col-lg-8 col-md-6 col-sm-12 col-xs-12'
    ],
    [
        'name' => 'parent',
        'helper' => null,
        'parameters' => ['class'=> 'form-control'],
        'label' => __('Parent'),
        'type' => 'OBJECT',
        'id' => 'parent',
        'width' => 'col-lg-8 col-md-6 col-sm-12 col-xs-12',
        'image' =>  !empty( $object) ? (!empty($object->parent()) && !empty($object->parent()->getImage()) ? $object->parent()->getImage(): null ) : null ,
        'object' => !empty($object) && !empty($object->parent) ? $object->parent() :  null
    ],
];
?>

@include('includes.create_field')

@section('new_scripts')
    @include('includes.create_field_script')
@endsection


