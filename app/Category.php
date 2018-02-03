<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
  public function products(){
  return $this->belongsToMany('App\Product','category_products');
  }
  public function getRouteKeyName()
  {
    return 'category_name';
  }
}
