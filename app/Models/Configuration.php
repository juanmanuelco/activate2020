<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    use HasFactory;

    public $table = 'configuration';

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
}
