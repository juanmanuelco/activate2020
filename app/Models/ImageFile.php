<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class ImageFile extends Model
{
    use HasFactory;
    use LogsActivity;
    public $table = 'image_files';
    protected static $logAttributes = ['*'];

    public $fillable = [
        'name',
        'extension',
        'size',
        'mimetype',
        'owner'
    ];

}
