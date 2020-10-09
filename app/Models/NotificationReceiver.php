<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationReceiver extends Model
{
    use HasFactory;
    public $table = 'notification_receivers';
    public $fillable = [
        'receiver',
        'type',
        'notification'
    ];

    public function notification(){
        return $this->belongsTo(Notification::class, 'notification', 'id');
    }

}
