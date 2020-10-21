<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Icon extends Model
{
    use HasFactory;
    use LogsActivity;
    public $table = 'icons';
    protected static $logAttributes = ['*'];


    public $fillable = [
        'name'
    ];
}
