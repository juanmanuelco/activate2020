<?php


namespace App\Repositories;


use App\Models\NotificationReceiver;

class NotificationReceiverRepository extends BaseRepository {

    public function getFieldsSearchable(){
        // TODO: Implement getFieldsSearchable() method.
    }

    public function search($param){
        $fields = NotificationReceiver::getModel()->getFillable();
        $response = NotificationReceiver::query();
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
        return NotificationReceiver::class;
    }
}
