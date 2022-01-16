<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Sale extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes, LogsActivity;

    public $table = 'sales';
    protected static $logAttributes = ['*'];

    protected $cascadeDeletes = [];

    public $fillable = [
        'seller',
        'assignment',
        'payment',
        'paid',
        'payment_date',
        'payer'
    ];

    public function getSeller(){
        return $this->hasOne(Seller::class, 'id', 'seller')->first();
    }

    public function getCard(){
        return $this->hasOne(Assignment::class, 'id', 'assignment')->first();
    }

    public function payer(){
        return $this->hasOne(User::class, 'id', 'payer')->first();
    }
}
