<?php


namespace App\Repositories;


use App\Models\Branch;
use App\Models\Card;
use App\Models\Market;

class MarketRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Market::class;
    }

    public function search($param){
        $fields = Market::getModel()->getFillable();
        $response = Market::query();
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

