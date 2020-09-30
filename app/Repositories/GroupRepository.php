<?php
namespace App\Repositories;
use App\Models\Group;
use App\Repositories\BaseRepository;

class GroupRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'icon'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Group::class;
    }

    public function search($param){
        return Group::search($param);
    }

    public function getFieldsSearchable()
    {
        // TODO: Implement getFieldsSearchable() method.
    }
}
