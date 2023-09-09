<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'id','id_entity','products','table','total','note','in_restaurant','status'
    ];

    public function entity()
    {
    	return $this->belongsTo('App\Models\Entities', 'id_entity');
    }
    
}
