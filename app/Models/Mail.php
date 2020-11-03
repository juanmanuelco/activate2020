<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mail extends Model
{
    use HasFactory;

    public $table = 'mails';
    protected static $logAttributes = ['*'];
    public $fillable = [
        'subject',
        'body'
    ];

}
