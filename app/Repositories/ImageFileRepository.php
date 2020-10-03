<?php


namespace App\Repositories;


use App\Models\ImageFile;

class ImageFileRepository extends BaseRepository
{

    public function getFieldsSearchable()
    {
        // TODO: Implement getFieldsSearchable() method.
    }

    public function model()
    {
        return ImageFile::class;
    }
}
