<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Application extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes, LogsActivity;

    public $table = 'applications';
    protected static $logAttributes = ['*'];


    public $fillable = [
        'assignment',
        'benefit'
    ];

    public function assignment(){
        return $this->hasOne(Assignment::class, 'id', 'assignment')->withTrashed();
    }
    public function getAssignment(){
        return $this->assignment()->first();
    }

    public function benefit(){
        return $this->hasOne(Benefit::class, 'id', 'benefit')->withTrashed();
    }
    public function getBenefit(){
        return $this->benefit()->withTrashed()->first();
    }
}
