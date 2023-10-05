<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entities extends Model
{
    protected $table = 'entities';

    protected $fillable = [
        'id','name','description','address','phone','email','latitude','length','image','tables','status'
    ];

    public function categories()
    {
    	return $this->hasMany('App\Models\Categories', 'id_entity');
    }

    public function products()
    {
    	return $this->hasMany('App\Models\Products', 'id_entity');
    }

}

