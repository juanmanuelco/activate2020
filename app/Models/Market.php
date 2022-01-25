<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Market extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes, LogsActivity;

    public $table = 'markets';
    protected static $logAttributes = ['*'];

    protected $cascadeDeletes = [];

    public $fillable = [
        'name',
        'image',
        'card'
    ];

    public function getImage(){
        return $this->hasOne(ImageFile::class, 'id', 'image')->first();
    }

    public function image(){
        return $this->hasOne(ImageFile::class, 'id', 'image');
    }

    public function card(){
        return $this->hasOne(Card::class, 'id', 'card')->first();
    }

}
