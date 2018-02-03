<?php

namespace App;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Order extends Model
{
  protected $fillable=['total','delivered','address','size','paymentStatus'];
public function user()
{
return $this->belongsTo(User::class);
}
public function orderItems()
{
return $this->belongsToMany(Product::class)->withPivot('qty','total','size');
}
public static function createOrder($address){

  $user= Auth::user();

  $order=$user->orders()->create([
      'total'=>Cart::total(2, '.', ''),
      'delivered'=>0,
      'address'=>$address,
      'paymentStatus'=>0
  ]);

  $cartItems=Cart::content();

  foreach ($cartItems as $cartItem){
      $order->orderItems()->attach($cartItem->id,[
          'qty'=>$cartItem->qty,
            'size'=>$cartItem->options->size,
          'total'=>$cartItem->qty*$cartItem->price
      ]);
  
  }

  return $order->id;
}
}
