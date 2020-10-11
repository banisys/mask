<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $guarded = [];

    public function galleries()
    {
        return $this->hasMany(Gallery::class, 'product_id');
    }

    public function cat()
    {
        return $this->belongsTo(Category::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class, 'product_id');
    }

    public function order_values()
    {
        return $this->hasMany(Order_value::class, 'product_id');
    }

    public function cart_values()
    {
        return $this->hasMany(Cart_value::class, 'product_id');
    }

    public function exists()
    {
        return $this->hasMany(Exist::class, 'product_id');
    }


}
