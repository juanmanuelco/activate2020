<?php


namespace App\Repositories;


use App\Models\Builder;

class BuilderRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'name',
        'session',
        'slug',
        'gjs-html',
        'gjs-components',
        'gjs-assets',
        'gjs-css',
        'gjs-styles',
        'option',
        'active'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Builder::class;
    }

    public function search($param){
        $fields = Builder::getModel()->getFillable();
        $response = Builder::query();
        if(!empty($param)){
            foreach ($fields as $field){
                $response = $response->orWhere($field, 'like', '%'.$param .'%');
            }
        }
        $response= $response->orderBy('name');
        return $response;
    }

    public function getFieldsSearchable()
    {
        // TODO: Implement getFieldsSearchable() method.
    }
}
