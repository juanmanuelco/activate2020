<?php


namespace App\Repositories;


use App\Models\Configuration;

class ConfigurationRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable =[
        'name',
        'type',
        'text',
        'number',
        'date',
        'time',
        'datetime',
        'boolean',
        'image'
    ];

    public function search($param){
        $fields = Configuration::getModel()->getFillable();
        $response = Configuration::query();
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

    public function model()
    {
        return Configuration::class;
    }
}
