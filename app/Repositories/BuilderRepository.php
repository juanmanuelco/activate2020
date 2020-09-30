<?php


namespace App\Repositories;


use App\Models\Builder;

class BuilderRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'name',
        'page',
        'slug'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Builder::class;
    }

    public function search($param){
        return Builder::search($param);
    }

    public function getFieldsSearchable()
    {
        // TODO: Implement getFieldsSearchable() method.
    }
}
