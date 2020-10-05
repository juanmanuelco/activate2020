<?php


namespace App\Repositories;


use Spatie\Permission\Models\Role;

class RoleRepository extends BaseRepository
{

    public function getFieldsSearchable()
    {
        // TODO: Implement getFieldsSearchable() method.
    }

    public function search($param){
        $fields =['name', 'guard_name'];
        $response = Role::query();
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
        return Role::class;
    }
}
