<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Builder extends Model
{
    use HasFactory, SoftDeletes;

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
