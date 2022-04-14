
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
        'object' => !empty($product) ? $product->description : null,
        'type' => 'TEXTAREA',
        'id' => 'description',
        'width' => 'col-lg-8 col-md-6 col-sm-12 col-xs-12'
    ],
    [
        'name' => 'code',
        'parameters' => ['class'=> 'form-control', 'required'=> true],
        'helper' => null,
        'label' => __('Code'),
        'object' => !empty($product) ? $product->code : null,
        'type' => 'TEXT',
        'id' => 'code',
        'width' => 'col-lg-8 col-md-6 col-sm-12 col-xs-12'
    ],
    [
        'name' => 'quantity',
        'parameters' => ['class'=> 'form-control', 'required'=> true, 'step' => 1],
        'helper' => null,
        'label' => __('Quantity'),
        'object' => !empty($product) ? $product->quantity : null,
        'type' => 'NUMBER',
        'id' => 'quantity',
        'width' => 'col-lg-8 col-md-6 col-sm-12 col-xs-12'
    ],
    [
        'name' => 'price',
        'parameters' => ['class'=> 'form-control', 'required'=> true, 'step' => 0.01],
        'helper' => null,
        'label' => __('Price'),
        'object' => !empty($product) ? $product->price : null,
        'type' => 'NUMBER',
        'id' => 'price',
        'width' => 'col-lg-8 col-md-6 col-sm-12 col-xs-12'
    ],
    [
        'name' => 'image',
        'label' => __('Image'),
        'object' => !empty($product) ? $product : null,
        'type' => 'IMAGE',
        'id' => 'image',
        'width' => 'col-lg-8 col-md-6 col-sm-12 col-xs-12'
    ]
];
?>


@include('includes.modal_image_selector')
@include('includes.create_field')

@section('new_scripts')
    @include('includes.create_field_script')
@endsection


