<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Branch extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes, LogsActivity;

    public $table = 'branches';
    protected static $logAttributes = ['*'];


    public $fillable = [
        'name',
        'store',
        'latitude',
        'longitude'
    ];

    public function store(){
        return $this->hasOne(Store::class, 'id', 'store')->first();
    }
}
