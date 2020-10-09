<?php


namespace App\Repositories;


use App\Models\GroupRole;

class GroupRoleRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'role',
        'group'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return GroupRole::class;
    }

    public function search($param){
        $fields = GroupRole::getModel()->getFillable();
        $response = GroupRole::query();
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


