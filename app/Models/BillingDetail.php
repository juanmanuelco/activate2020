<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class BillingDetail extends Model
{
    use HasFactory,  LogsActivity;

    public $table = 'billing_detail';
    protected static $logAttributes = ['*'];


    public $fillable = [
        'name',
        'description',
        'billing',
        'image',
        'code',
        'price',
        'quantity'
    ];
}
