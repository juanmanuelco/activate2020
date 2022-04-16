<?php

namespace App\Repositories;

use App\Models\Billing;

class BillingRepository extends BaseRepository{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'subtotal',
        'discount',
        'total',
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Billing::class;
    }

    public function search($param){
        $fields = Billing::getModel()->getFillable();
        $response = Billing::query();
        if(!empty($param)){
            foreach ($fields as $field){
                $response = $response->orWhere($field, 'like', '%'.$param .'%');
            }
        }
        $response = $response->orderBy('id');
        return $response;
    }

    public function getFieldsSearchable()
    {
        // TODO: Implement getFieldsSearchable() method.
    }
}
