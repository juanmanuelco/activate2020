<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class NotificationReaded extends Model
{
    use HasFactory;
    use LogsActivity;

    /**
     * @var string
     */
    public $table = 'notification_readeds';
    protected static $logAttributes = ['*'];
    /**
     * @var string[]
     */
    public $fillable = [
        'reader',
        'notification'
    ];
}
