<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasMany;

class Entities extends Model
{
    use HasFactory;

    protected $table = 'entities';

    protected $guarded = [];

    protected $fillable = [
        'id','id_plan','name','description','address','phone','email','latitude','length','image','tables','status'
    ];

    public function plans()
    {
    	return $this->belongsTo('App\Models\Plans', 'id_plan');
    }

    public function categories()
    {
    	return $this->hasMany('App\Models\Categories', 'id_entity');
    }

    public function products()
    {
    	return $this->hasMany('App\Models\Products', 'id_entity');
    }

}

