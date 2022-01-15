<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Card extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes, LogsActivity;

    public $table = 'cards';
    protected static $logAttributes = ['*'];

    public $fillable = [
        'name',
        'subtitle',
        'price',
        'start',
        'end',
        'instagram',
        'facebook',
        'days',
        'points',
        'image',
        'hidden'
    ];

    public function getImage(){
        return $this->hasOne(ImageFile::class, 'id', 'image')->first();
    }

    public function stores(){
        return $this->belongsToMany(Store::class, 'store_cards', 'card', 'store');
    }
}