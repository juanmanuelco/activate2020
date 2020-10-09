<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationReaded extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    public $table = 'notification_readeds';
    /**
     * @var string[]
     */
    public $fillable = [
        'reader',
        'notification'
    ];
}
