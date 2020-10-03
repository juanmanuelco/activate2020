<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageFile extends Model
{
    use HasFactory;
    public $table = 'image_files';

    public $fillable = [
        'name',
        'extension',
        'size',
        'mimetype'
    ];

}
