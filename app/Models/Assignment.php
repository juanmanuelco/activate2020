<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Assignment extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes, LogsActivity;

    public $table = 'assignments';
    protected static $logAttributes = ['*'];

    public $fillable = [
        'seller',
        'card',
        'number',
        'code',
        'type',
        'email',
        'price',
        'start',
        'end',
        'sale_date'
    ];

    public function getCard(){
        return $this->hasOne(Card::class, 'id', 'card')->withTrashed()->first();
    }
    public function card(){
        return $this->hasOne(Card::class, 'id', 'card')->withTrashed();
    }
    public function getSeller(){
        return $this->hasOne(Seller::class, 'id', 'seller')->first();
    }
    public function payments(){
        return $this->hasMany(Sale::class, 'assignment', 'id');
    }

    public function getPayments(){
        return $this->hasMany(Sale::class, 'assignment', 'id')->get();
    }
    public function user(){
        return $this->hasOne(User::class, 'email', 'email');
    }
}
