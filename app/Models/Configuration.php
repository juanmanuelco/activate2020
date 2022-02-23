<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Configuration extends Model
{
    use HasFactory;
    use LogsActivity;
    public $table = 'configuration';
    protected static $logAttributes = ['*'];

    public $fillable = [
        'name',
        'type',
        'text',
        'number',
        'date',
        'time',
        'datetime',
        'boolean',
        'image'
    ];

    protected $appends = ['exists'];

    /**
     * Define the type column to every Item object instance
     *
     * @return string
     */
    public function getExistsAttribute()
    {
        return true;
    }

    public function image(){
        return $this->hasOne(ImageFile::class, 'id', 'image');
    }
}
