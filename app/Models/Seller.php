<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Seller extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes, LogsActivity;

    public $table = 'sellers';
    protected static $logAttributes = ['*'];

    protected $cascadeDeletes = [];

    public $fillable = [
        'name',
        'commission',
        'gains',
        'user',
        'superior'
    ];

    public function getUser(){
        return $this->hasOne(User::class, 'id', 'user')->first();
    }

    public function getSuperior(){
        return $this->hasOne(User::class, 'id', 'superior')->first();
    }
}
