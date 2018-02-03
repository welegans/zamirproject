<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
use App\Address;
use App\User;
use App\Size;
use App\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Gloudemans\Shoppingcart\Facades\Cart;

class ProductController extends Controller
{
  public function product()
  {
    $products = Product::where('status',1)->orderBy('created_at','desc')->get()->sortByDesc('created_at');
    return view('user.products',compact('products'));
  }

  public function index()
  {
    $products = Product::where('status',1)->orderBy('created_at','desc')->get()->sortByDesc('created_at');
    // dd($products);
    $categories =category::all();
    $sizes =size::all();
    return view('user.products',compact('products','categories','sizes'));
    // return view('user.products',compact('products','categories'));
  }
  public function getAllproducts()
  {
    $products = Product::where('status',1)->orderBy('created_at','desc')->get()->sortByDesc('created_at');
  }
  public function logoutUser()
  {
    if (Auth::check()) {
      $user = Auth::user();
      // if (Cart::count()!=0) {
      // dd(Cart::content());
      Cart::store($user->id);

    }
    Auth::logout();
    Cart::destroy();
    return redirect()->route('home');
  }
  public function show()
  {
    if (Auth::check()) {
      $user = Auth::user();
      Cart::restore($user->id);
      $cartItems = Cart::content();
    }
    $cartItems = Cart::content();
    //$products = Product::all()->sortByDesc('created_at');
    $products = Product::where('status',1)->orderBy('created_at','desc')->limit(16)->get()->sortByDesc('created_at');
    $categories =category::all();
    $sizes =size::all();
    return view('user.index',compact('products','categories','cartItems','sizes'));
  }
  public function profile()
  {
    $products = Product::where('status',1)->orderBy('created_at','desc')->get()->sortByDesc('created_at');
    $categories =category::all();
    $user = auth::user();
    // dd($user);
    $addresses = User::find($user->id)->address()->get();
    // dd('got');
    //$addresses =   Address::where('user_id', $user->id)->get();
    //dd($address->state);
    // $genders =gender::all();
    return view('user.profile',compact('products','categories','user', 'addresses'));
  }
  public function details($id)
  {
    // Cart::update($id,['qty'=>$request->qty]);
    // $category = category::where('id',$id)->first();
    $sizes =size::all();
    $categories =category::all();
    // $products=Product::find($id);
    $products = Product::where('status',1)->orderBy('created_at','desc')->get()->sortByDesc('created_at');

    $products=Product::where('status',1)->with('sizes')->find($id);
    // dd(explode(',', $products->image));
    return view('user.details',compact('products','categories','sizes'));
  }
  // public function gender(gender $gender)
  // {
  //   $products = $gender->products();
  //   return view('user.products',compact('products'));
  // }
  public function category(category $category)
  {
    $sizes =size::all();
    $categories =category::all();
    $productsall= $category->products;
    $products=$productsall->where('status',1)->sortByDesc('created_at');
    return view('user.products',compact('products','categories','sizes'));
  }
  public function size(size $size)
  {
    $sizes =size::all();
    $categories =category::all();
    $productsall= $category->products;
    $products=$productsall->where('status',1)->sortByDesc('created_at');
    return view('user.products',compact('products','categories','sizes'));
  }

  public function success()
  {
    $products = Product::where('status',1)->orderBy('created_at','desc')->get()->sortByDesc('created_at');
    $categories =category::all();
    // $sizes =size::all();
    return view('user.success',compact('products','categories'));
  }
  public function failure()
  {
    $products = Product::where('status',1)->orderBy('created_at','desc')->get()->sortByDesc('created_at');
    $categories =category::all();
    // $sizes =size::all();
    return view('user.failure',compact('products','categories'));
  }

  public function userOrders()
  {
    $user = auth::user();
    $userId =$user->id;
    $categories =category::all();
    // $orders =order::where('user_id',$userId)->get();
    $orders = User::find($userId)->orders()->get();
    // $updatedOrderDetails= Order::find($orders->id);
    //
    // $products = $updatedOrderDetails->orderItems()->get();
    // dd($products);
    $products = Product::where('status',1)->orderBy('created_at','desc')->get()->sortByDesc('created_at');
    // $addresses = User::find($user->id)->address()->get();
    return view('user.orders',compact('products','categories','user','orders'));
  }
}
