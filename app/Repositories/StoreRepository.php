<?php


namespace App\Repositories;


use App\Models\Store;

class StoreRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'description',
        'image',
        'facebook',
        'instagram',
        'web_page',
        'phone',
        'schedule',
        'category'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Store::class;
    }

    public function search($param){
        $fields = Store::getModel()->getFillable();
        $response = Store::query();
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
}

