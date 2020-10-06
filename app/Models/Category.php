<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];

    public function products()
    {
        return $this->hasMany(Product::class, 'cat_id');
    }


    public function child()
    {
        return $this->hasMany(Category::class, 'parent');
    }

    public function childrenRecursive()
    {
        return $this->child()->with('childrenRecursive');
    }

    public function brands()
    {
        return $this->belongsToMany(Brand::class,'brand_category','cat_id');
    }

}
