<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupRole extends Model
{
    use HasFactory;
    public $table = 'groups_roles';


    public $fillable = [
        'role',
        'group'
    ];
}
