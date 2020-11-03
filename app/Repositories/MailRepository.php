<?php


namespace App\Repositories;


use App\Models\Mail;

class MailRepository extends BaseRepository
{

    public function getFieldsSearchable()
    {
        // TODO: Implement getFieldsSearchable() method.
    }


    public function model()
    {
        return Mail::class;
    }
}
