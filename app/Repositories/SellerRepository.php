<?php


namespace App\Repositories;


use App\Models\Branch;
use App\Models\Card;
use App\Models\Market;
use App\Models\Seller;

class SellerRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'commission',
        'gains'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Seller::class;
    }

    public function search($param){
        $fields = Seller::getModel()->getFillable();
        $response = Seller::query();
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

