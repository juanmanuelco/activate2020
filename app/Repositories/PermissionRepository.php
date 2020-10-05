<?php


namespace App\Repositories;


use Spatie\Permission\Models\Permission;

class PermissionRepository extends BaseRepository
{

    public function getFieldsSearchable()
    {
        // TODO: Implement getFieldsSearchable() method.
    }

    public function search($param){
        $fields = ['name', 'guard_name', 'group', 'detail'];
        $response = Permission::query();
        if(!empty($param)) {
            foreach ($fields as $field) {
                $response = $response->orWhere($field, 'like', '%' . $param . '%');
            }
        }
        return $response->orderBy('name');
    }

    public function orderBy($param){
        return $this->orderBy($param);
    }

    public function model()
    {
        return Permission::class;
    }
}
