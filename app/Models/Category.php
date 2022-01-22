<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Models\Permission;

class Category extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes, LogsActivity;

    public $table = 'categories';
    protected static $logAttributes = ['*'];

    protected $cascadeDeletes = [];

    public $fillable = [
        'name',
        'description',
        'parent',
        'image',
        'color'
    ];

    public function parent(){
        return $this->hasOne(Category::class, 'id', 'parent')->first();
    }

    public function children(){
        return $this->hasMany(Category::class, 'parent', 'id')->get();
    }



    public function getImage(){
        return $this->hasOne(ImageFile::class, 'id', 'image')->first();
    }

    public function image(){
        return $this->hasOne(ImageFile::class, 'id', 'image');
    }

    public function stores(){
        return $this->hasMany(Store::class, 'category', 'id');
    }

}
