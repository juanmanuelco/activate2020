<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailReceiver extends Model
{
    use HasFactory;

    public $table = 'mail_receivers';
    protected static $logAttributes = ['*'];
    public $fillable = [
        'receiver',
        'mail'
    ];
}
