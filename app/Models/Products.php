<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'id','id_entity','category_id','name','description','price','image','status'
    ];

    public function entity()
    {
    	return $this->belongsTo('App\Models\Entities', 'id_entity');
    }

    public function categories()
    {
    	return $this->belongsTo('App\Models\Categories', 'category_id');
    }
}
