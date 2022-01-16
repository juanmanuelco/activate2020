<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Benefit extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes, LogsActivity;

    public $table = 'benefits';
    protected static $logAttributes = ['*'];


    public $fillable = [
        'name',
        'benefit',
        'restriction',
        'points',
        'gains',
        'unlimited',
        'image',
        'store'
    ];

    public function store(){
        return $this->hasOne(Store::class, 'id', 'store');
    }

    public function getImage(){
        return $this->hasOne(ImageFile::class, 'id', 'image')->first();
    }

    public function image(){
        return $this->hasOne(ImageFile::class, 'id', 'image');
    }
}
