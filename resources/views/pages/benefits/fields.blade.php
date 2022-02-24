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
            'name' => 'benefit',
            'helper' => null,
            'label' => __('Benefits'),
            'object' => !empty($benefit) ? $benefit->benefit : null,
            'type' => 'TEXTAREA',
            'id' => 'benefit',
            'width' => 'col-lg-8 col-md-6 col-sm-12 col-xs-12'
        ],
        [
            'name' => 'restriction',
            'helper' => null,
            'label' => __('Restrictions'),
            'object' => !empty($benefit) ? $benefit->restriction : null,
            'type' => 'TEXTAREA',
            'id' => 'restriction',
            'width' => 'col-lg-8 col-md-6 col-sm-12 col-xs-12'
        ],
        [
            'name' => 'unlimited',
            'helper' => null,
            'label' => __('Unlimited'),
            'object' => empty($object) ? null : $object->unlimited,
            'type' => 'CHECKBOX',
            'id' => 'restriction',
            'width' => 'col-lg-2 col-md-2 col-sm-2 col-xs-2'
        ],
        [
            'name' => 'points',
            'parameters' => ['class'=> 'form-control', 'min'=>0, 'max' => 10],
            'helper' => null,
            'label' => __('Points by use'),
            'type' => 'NUMBER',
            'id' => 'points',
            'width' => 'col-lg-4 col-md-6 col-sm-12 col-xs-12'
        ],
        [
            'name' => 'gains',
            'parameters' => ['class'=> 'form-control', 'min'=>0, 'step'=>0.01, 'max' => 1000],
            'helper' => null,
            'label' => __('Gains by use'),
            'type' => 'NUMBER',
            'id' => 'gains',
            'width' => 'col-lg-4 col-md-6 col-sm-12 col-xs-12'
        ]
    ];
?>

@include('includes.create_field')

@section('new_scripts')
    @include('includes.create_field_script')
@endsection

