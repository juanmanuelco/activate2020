<?php


namespace App\Repositories;


use App\Models\Category;

class CategoryRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'description',
        'image'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Category::class;
    }

    public function search($param){
        $fields = Category::getModel()->getFillable();
        $response = Category::query();
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

