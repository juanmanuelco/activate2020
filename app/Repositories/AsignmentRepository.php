<?php


namespace App\Repositories;


use App\Models\Assignment;
use App\Models\Branch;
use App\Models\Card;

class AsignmentRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Assignment::class;
    }

    public function search($param){
        $fields = Card::getModel()->getFillable();
        $response = Card::query();
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

