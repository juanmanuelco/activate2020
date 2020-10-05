<?php


namespace App\Repositories;


use App\Models\User;

class UserRepository extends BaseRepository
{

    public function getFieldsSearchable()
    {
        // TODO: Implement getFieldsSearchable() method.
    }

    public function search($param){
        $fields = User::getModel()->getFillable();
        $response = User::query();
        if(!empty($param)) {
            foreach ($fields as $field) {
                $response = $response->orWhere($field, 'like', '%' . $param . '%');
            }
        }
        $response = $response->orderBy('name');
        return $response;
    }

    public function model()
    {
        return User::class;
    }
}
