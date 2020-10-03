<?php


namespace App\Repositories;


use App\Models\Group;

class GroupRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'icon'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Group::class;
    }

    public function search($param){
        $fields = Group::getModel()->getFillable();
        $response = Group::query();
        foreach ($fields as $field){
            $response = $response->orWhere($field, 'like', '%'.$param .'%');
        }
        return $response;
    }

    public function getFieldsSearchable()
    {
        // TODO: Implement getFieldsSearchable() method.
    }
}

