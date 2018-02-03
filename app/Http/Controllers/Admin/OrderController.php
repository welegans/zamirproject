<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderShipped;
// use Mail;
class OrderController extends Controller
{
  public function __construct()
    {
        $this->middleware('auth:admin');
    }
  public function Orders($type='')
  {
    if($type =='pending'){
      $orders=Order::where('delivered','0')->get();
    }elseif ($type == 'delivered'){
      $orders=Order::where('delivered','1')->get();
    }else{
      $orders=Order::all();
    }
    return view('admin.orders',compact('orders'));
  }
  public function toggledeliver(Request $request,$orderId)
  {
    $order=Order::find($orderId);
    if($request->has('delivered')){
      $time=Carbon::now()->addMinute(1);
      // dd($order->user->email);
      // Mail::send(['text'=>'emails/mail'], ["name"=>"git"], function($message) {
      //    $message->to('gitanjalight@gmail.com', 'Tutorials Point')->subject
      //       ('Laravel Basic Testing Mail');
      //    $message->from('orders@feetnfeel.com','Virat Gandhi');
      // });

      // Mail::send('emails.mail',$mailData , function ($message) use ($cdata) {
      //   $message->from('tabishbot@gmail.com', 'FeetnFeel');
      //   $message->to($cdata['email'])->subject('Your FeetnFeel Order Id #'.$cdata['orderId'].' has been confirmed.');
      // });
      //Mail::to($order->user->email)->later($time,new OrderShipped($order));
      $order->delivered=$request->delivered;
    }else{
      $order->delivered="0";
    }
    $order->save();
    return back();
  }
}
