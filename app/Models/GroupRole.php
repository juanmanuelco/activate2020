<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class GroupRole extends Model
{
    use HasFactory;
    use LogsActivity;
    public $table = 'groups_roles';
    protected static $logAttributes = ['*'];


    public $fillable = [
        'role',
        'group'
    ];
}
