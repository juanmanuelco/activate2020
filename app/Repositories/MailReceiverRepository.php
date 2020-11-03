<?php


namespace App\Repositories;


use App\Models\MailReceiver;

class MailReceiverRepository extends BaseRepository
{

    public function getFieldsSearchable()
    {
        // TODO: Implement getFieldsSearchable() method.
    }


    public function model()
    {
        return MailReceiver::class;
    }
}
