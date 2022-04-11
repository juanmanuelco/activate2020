<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository extends BaseRepository {
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'description',
        'price',
        'code'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Product::class;
    }

    public function search($param){
        $fields = Product::getModel()->getFillable();
        $response = Product::query();
        if(!empty($param)){
            foreach ($fields as $field){
                $response = $response->orWhere($field, 'like', '%'.$param .'%');
            }
        }
        $response = $response->orderBy('name');
        return $response;
    }

    public function getFieldsSearchable()
    {
        // TODO: Implement getFieldsSearchable() method.
    }
}
