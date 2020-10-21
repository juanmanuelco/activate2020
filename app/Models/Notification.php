<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Traits\LogsActivity;

class Notification extends Model
{
    use HasFactory;
    use LogsActivity;

    public $table = 'notifications';
    protected static $logAttributes = ['*'];
    public $fillable = [
        'detail',
        'emisor',
        'icon',
        'title',
        'image'
    ];


    public function receivers(){
        return $this->hasMany(NotificationReceiver::class, 'notification', 'id');
    }

    public function readed (){
        return $this->hasOne(NotificationReceiver::class, 'notification', 'id')->where('receiver', Auth::user()->id);
    }

    public function getImage(){
        return $this->hasOne(ImageFile::class, 'id', 'image')->first();
    }
}
