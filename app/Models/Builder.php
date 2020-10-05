<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Builder extends Model
{
    use HasFactory;

    public $table = 'builders';

    public $fillable = [
        'name',
        'session',
        'slug',
        'gjs-html',
        'gjs-components',
        'gjs-assets',
        'gjs-css',
        'gjs-styles'
    ];
}
