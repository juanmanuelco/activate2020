<?php


namespace App\Repositories;


use App\Models\NotificationReaded;

class NotificationReadedRepository  extends BaseRepository {

    public function getFieldsSearchable(){
        // TODO: Implement getFieldsSearchable() method.
    }

    public function search($param){
        $fields = NotificationReaded::getModel()->getFillable();
        $response = NotificationReaded::query();
        if(!empty($param)) {
            foreach ($fields as $field) {
                $response = $response->orWhere($field, 'like', '%' . $param . '%');
            }
        }
        return $response->orderBy('id');
    }

    public function orderBy($param){
        return $this->orderBy($param);
    }

    public function model(){
        return NotificationReaded::class;
    }
}
