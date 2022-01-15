<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Store extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes, LogsActivity;

    public $table = 'stores';
    protected static $logAttributes = ['*'];

    protected $cascadeDeletes = [];

    public $fillable = [
        'name',
        'description',
        'image',
        'facebook',
        'instagram',
        'web_page',
        'phone',
        'schedule',
        'owner',
        'category'
    ];

    public function owner(){
        return $this->hasOne(User::class, 'id', 'owner')->first();
    }

    public function category(){
        return $this->hasOne(Category::class, 'parent', 'id')->first();
    }

    public function getImage(){
        return $this->hasOne(ImageFile::class, 'id', 'image')->first();
    }

    public function branches(){
        return $this->hasMany(Branch::class, 'store', 'id');
    }

    public function benefits(){
        return $this->hasMany(Benefit::class, 'store', 'id');
    }

    public function branchesJson(){
        $the_branches =  $this->branches()->get();
        $response = [];
        foreach ($the_branches as $branch){
            array_push($response, [
                'id' => $branch->id,
                'name' => $branch->name,
                'latitude' => $branch->latitude,
                'longitude' => $branch->longitude,
                'exists' => true
            ]);
        }
        return $response;
    }
}
