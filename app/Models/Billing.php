<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Billing extends Model
{
    use HasFactory,  LogsActivity;

    public $table = 'billing';
    protected static $logAttributes = ['*'];


    public $fillable = [
        'subtotal',
        'discount',
        'total',
    ];

    public function details(){
        return $this->hasMany(BillingDetail::class, 'billing', 'id');
    }
}
