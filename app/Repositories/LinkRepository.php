<?php


namespace App\Repositories;


use App\Models\Link;

class LinkRepository extends BaseRepository
{

    public function getFieldsSearchable()
    {
        // TODO: Implement getFieldsSearchable() method.
    }

    public function search($param){
        $fields = Link::getModel()->getFillable();
        $response = Link::query();
        if(!empty($param)){
            foreach ($fields as $field){
                $response = $response->orWhere($field, 'like', '%'.$param .'%');
            }
        }
        $response = $response->orderBy('name');
        return $response;
    }

    public function model()
    {
       return Link::class;
    }
}
