<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'id','category_id','name','description','price','image','status'
    ];

    public function categories()
    {
    	return $this->belongsTo('App\Models\Categories', 'category_id');
    }
}
