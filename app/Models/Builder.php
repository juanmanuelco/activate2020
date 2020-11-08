<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;


class Builder extends Model
{
    use HasFactory;
    use LogsActivity;
    public $table = 'builders';

    protected static $logAttributes = ['*'];

    public $fillable = [
        'name',
        'session',
        'slug',
        'gjs-html',
        'gjs-components',
        'gjs-assets',
        'gjs-css',
        'gjs-styles',
        'option',
        'active'
    ];
}
