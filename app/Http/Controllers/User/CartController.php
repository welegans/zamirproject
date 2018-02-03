<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use App\Product;
use App\Category;
use App\Size;

class CartController extends Controller
{

  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    if (Auth::check()) {
      $user = Auth::user();
      // Cart::restore($user->id);
      // Cart::store($user->id);
      // dd(Cart::content());
      $cartItems = Cart::content();
    }
    $categories = category::all();
    $cartItems = Cart::content();
    // foreach ($cartItems as $key => $value) {
    //   dd($value->id);
    // }
    //dd($cartItems->id);
    //$sizes =size::all();
    //$sizes = product::find(5)->sizes()->get();
    return view('cart.index',compact('cartItems' , 'categories'));
  }
  /**
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function create()
  {
    //
  }
  /**
  * Store a newly created resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
  public function store(Request $request,$id)
  {
    // dd($request->all());
    $sizes =size::all();
    $product = product::with('sizes')->find($id);
    $image = asset('productImages/' .explode(',', $product->image)[0]);
    //dd($id);
    if (Auth::check()) {
      $user = Auth::user();
      Cart::add($id,$product->title,1,$product->price,['size' => $request->size,'image' => $image]);
      // Cart::store($user->id);
    }else{
      // Cart::add($id,$product->title,1,$product->price,['selsize'=> 'update'],['size' => $product->sizes,'image' => $product->image]);
      Cart::add($id,$product->title,1,$product->price,['size' => $request->size,'image' => $image]);
      // Cart::add($id,$product->title,1,$product->price,['image' => $product->image]);
    }
        return redirect()->back();
  }
  public function storeBuy(Request $request,$id)
  {
    // dd($request);
    $sizes =size::all();
    $product = product::with('sizes')->find($id);
    $image = asset('productImages/' .explode(',', $product->image)[0]);
    if (Auth::check()) {
      $user = Auth::user();
      Cart::add($id,$product->title,1,$product->price,['size' => $request->size,'image' => $image]);
    }else{
      Cart::add($id,$product->title,1,$product->price,['size' => $request->size,'image' => $image]);
    }
    return redirect()->route('checkout.shipping');
  }
  public function update(Request $request, $id)
  {
    // dd($request->all());
    if (Auth::check()) {
      $user = Auth::user();
      Cart::update($id,['qty'=>$request->qty,"options"=>['size'=>$request->size]]);
      // Cart::store($user->id);
      // dd(Cart::content());
    }else{
      Cart::update($id,['qty'=>$request->qty,"options"=>['size'=>$request->size,'image'=>$request->image]]);
    }


    return back();
  }
  /**
  * Display the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function show($id)
  {
    //
  }
  /**
  * Show the form for editing the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function edit($id)
  {
    //
  }
  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */


  /**
  * Remove the specified resource from storage.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function destroy($id)
  {
    Cart::remove($id);
    return back();
  }
}
