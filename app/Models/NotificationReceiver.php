<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class NotificationReceiver extends Model
{
    use HasFactory;
    use LogsActivity;
    public $table = 'notification_receivers';
    protected static $logAttributes = ['*'];
    public $fillable = [
        'receiver',
        'type',
        'notification'
    ];

    public function notification(){
        return $this->belongsTo(Notification::class, 'notification', 'id');
    }

}
