<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = ['name', 'description', 'image', 'cat_id', 'name_f'];


    public function cats()
    {
        return $this->belongsToMany(Category::class,'brand_category','brand_id','cat_id');
    }


}


