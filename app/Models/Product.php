<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $fillable = [
        'name', 'description', 'short_desc', 'cat_id', 'price', 'tags', 'image', 'discount', 'status', 'brand','effect_spec_id',
        'shamsi_c', 'shamsi_u', 'admin_id','status','seo_title','seo_key','seo_description','slug','brand_id','code'
    ];

    public function colors()
    {
        return $this->hasMany(Color::class, 'product_id');
    }

    public function galleries()
    {
        return $this->hasMany(Gallery::class, 'product_id');
    }

    public function cat()
    {
        return $this->belongsTo(Category::class);
    }

    public function spec_values()
    {
        return $this->hasMany(Spec_value::class, 'product_id');
    }

    public function effect_values()
    {
        return $this->hasMany(Effect_value::class, 'product_id');
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

    public function favourites()
    {
        return $this->hasMany(Favourite::class, 'product_id');
    }

    public function offers()
    {
        return $this->hasMany(Offer::class, 'product_id');
    }

    public function exists()
    {
        return $this->hasMany(Exist::class, 'product_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'product_id');
    }

}
