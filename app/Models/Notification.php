<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class Notification extends Model
{
    use HasFactory;


    public $table = 'notifications';
    public $fillable = [
        'detail',
        'emisor',
        'cursor'
    ];


    public function receivers(){
        return $this->hasMany(NotificationReceiver::class, 'notification', 'id');
    }

    public function readed (){
        return $this->hasOne(NotificationReceiver::class, 'notification', 'id')->where('receiver', Auth::user()->id);
    }
}
