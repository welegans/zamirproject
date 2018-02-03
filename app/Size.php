<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
  public function products(){
  return $this->belongsToMany('App\Product','size_products');
  }
  public function getRouteKeyName()
  {
    return 'size';
  }
}
