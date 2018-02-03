<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
  public function categories()
  {
    return $this->belongsToMany('App\Category','category_products')->withTimestamps();;
  }
  // public function genders()
  // {
  //   return $this->belongsToMany('App\gender','gender_products')->withTimestamps();;
  // }
  public function getRouteKeyName()
  {
    return ['category_name' , 'size'];
  }
  public function getCartegory_nameAttribute($value)
  {
    return route('products',$value);
  }
  public function sizes()
  {
    return $this->belongsToMany('App\Size','size_products')->withTimestamps();;
  }

  public function getSizeAttribute($value)
  {
    return route('products',$value);
  }
  // public function ordersp()
  // {
  //   return $this->belongsToMany('App\Order','order_products')->withTimestamps();;
  // }
  //
  // public function getOrderAttribute($value)
  // {
  //   return route('products',$value);
  // }
}
