<?php


namespace App\Repositories;


use App\Models\Benefit;
use App\Models\Branch;

class BenefitRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'benefit',
        'restriction',
        'points',
        'gains',
        'unlimited',
        'image',
        'store'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Benefit::class;
    }

    public function search($param){
        $fields = Benefit::getModel()->getFillable();
        $response = Benefit::query();
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

