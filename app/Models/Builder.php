<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use AjCastro\Searchable\Searchable;


class Builder extends Model
{
    use HasFactory, SoftDeletes, Searchable;

    public $table = 'groups';

    public $fillable = [
        'name',
        'slug',
        'page'
    ];
}
