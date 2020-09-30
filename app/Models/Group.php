<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Permission;
use AjCastro\Searchable\Searchable;

class Group extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes, Searchable;

    public $table = 'groups';

    protected $cascadeDeletes = ['roles'];

    public $fillable = [
        'name',
        'icon'
    ];

    public function roles(){
        return $this->hasMany(GroupRol::class, 'group', 'id');
    }

    public function permissions(){
        return $this->hasMany(Permission::class, 'group', 'id');
    }

}
