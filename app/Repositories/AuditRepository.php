<?php

namespace App\Repositories;
use Spatie\Activitylog\Models\Activity;

class AuditRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'log_name',
        'description',
        'subject_type',
        'causer_type',
        'properties'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Activity::class;
    }

    public function search($param){
        $fields = [
            'log_name',
            'description',
            'subject_type',
            'causer_type',
            'properties'
        ];
        $response = Activity::query();
        if(!empty($param)){
            foreach ($fields as $field){
                $response = $response->orWhere($field, 'like', '%'.$param .'%');
            }
        }
        $response= $response->orderBy('created_at', 'desc');
        return $response;
    }

    public function getFieldsSearchable()
    {
        // TODO: Implement getFieldsSearchable() method.
    }
}

