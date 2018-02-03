<?php

namespace App\Http\Controllers\User;

use App\Address;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Order;
use App\Category;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Mail;

class CheckoutController extends Controller
{

  public function step1()
  {
    if(auth::check()){
      return redirect()->route('checkout.shipping');
    }
    return redirect('login');
  }

  public function shipping()
  {
    if(auth::check()){
      $user = Auth::user();
      $addresses = address::where('user_id',$user->id)->get();
      // $products = Product::where('status',1)->orderBy('created_at','desc')->get()->sortByDesc('created_at');
      // $orders = Order::find($orderId);
      $categories = category::all();
      return view('user.shipping',compact('categories','addresses'));
    }
    return redirect('login');
  }

  public function payment()
  {
    return view('user.payment');
  }
  public function storePayment(Request $request,$id)
  {
    $request = address::where('id',$id)->first();

    // $this->validate($request,[
    //   'address'=>'required',
    //   'city'=>'required',
    //   'state'=>'required',
    //   'zip'=>'required|integer',
    //   'phone'=>'required|regex:/^[0-9\-\+]{9,15}$/',
    // ]);
    //dd($request);
    $domain_url = "http://feetnfeel.com";

    // $domain_url = "https://bqofkbcuyk.localtunnel.me";
    //$domain_url = "";
    //"http://127.0.0.1:8000";
    //paramters to be passed to payment take from the order/request
    //dd(Cart::total()*1000);
    //To do before making http request save the order and give status to order table
    //add address before order insert into orders
    $address = $request->address.", City : ".$request->city.", State : ".$request->state.", Zip :".$request->zip.", Country : ".$request->country;
    //dd($address);
    // Auth::user()->address()->create($request->all());
    //     $flight = App\Flight::updateOrCreate(
    //     ['departure' => 'Oakland', 'destination' => 'San Diego'],
    //     ['price' => 99]
    // );
    // dd(Cart::content());
    $order_id = Order::createOrder($address);
    //dd($order_id);
    $body = [
      'purpose' => "Order for ".$order_id,
      'amount' => Cart::total(2, '.', ''),
      'phone' => $request->phone,
      'buyer_name' =>   Auth::user()->name,
      'email' =>  Auth::user()->email,
      'redirect_url' => $domain_url.'/paymentStatus',
      'send_email' => false,
      'webhook' => $domain_url.'/webhook',
      'send_sms' => false,
      'allow_repeated_payments' => false
    ];


    //make http create payment requests
    $res = $this->makeHttpCall('POST', 'payment-requests/', [], 'form_params', $body);
    //Check the status of the request
    $statusCode = $res->getStatusCode();

    //If success i.e 201 created forward the Customer.
    if($statusCode == 201){
      $body = json_decode($res->getBody());
      Log::info((array)$body);
      Order::where('id', $order_id)->update(['paymentRequestId' => $body->payment_request->id]);
      //redirect to the payment interface.
      return redirect($body->payment_request->longurl);
    }else{
      //blade of error occurred
      return "handle the payment creation failure and let the user try again";
    }
  }
  /*
  After payment user is redirected here
  @request param contains
  @payment_id = "payment id is passed in the redirect url"
  @payment_request_id = "payment_request_id is passed in the redirect url"
  AFTER THE PAYMENT INTERFACE USER IS REDIRECTED TO THIS CONTROLLER
  Http call to get the details of the payment using the payment_id
  Process logic

  on succesfull payment and Failed payment
  */
  public function paymentDetails(Request $request)
  {
    $payment_id = $request->payment_id;
    $payment_request_id = $request->payment_request_id;

    //passsing bodytype and body as null as 'GET' doesn't contains request body
    $res = $this->makeHttpCall('GET', 'payments/'.$payment_id, [], null, null);
    //check status code of response
    $statusCode = $res->getStatusCode();
    if($statusCode == 200){
      //Get the json body from the response
      $body = json_decode($res->getBody());
      //if payment success
      if($body->success == true){
        Log::info("Succes payment status");
        //succes blade can event show the order product
        //Empty cart here
        Cart::destroy();
        return redirect()->route('success');
      }else{
        //payment failed
        return redirect()->route('failure');
      }
    }else{
      //Some error in transaction
      return "Error in the http call handle it";
    }
  }

  public function updateOrder(Request $request){
    //Get the json body from the response
    Log::info($request->all());
    Log::info("Full url".$request->Url());
    //passsing bodytype and body as null as 'GET' doesn't contains request body
    $res = $this->makeHttpCall('GET', 'payments/'.$request->payment_id, [], null, null);
    //check status code of response
    $statusCode = $res->getStatusCode();
    if($statusCode == 200){
      //Get the json body from the response
      $body = json_decode($res->getBody());
      //if payment success
      if($body->success == true){

        if( $request->status == "Credit"){
          Log::info("Succes payment status TT");
          $purposeArray = explode(" ",$request->purpose);
          $orderId = $purposeArray[2];
          $orderDetails= Order::find($orderId);
          $paymentRequestId = $orderDetails->paymentRequestId;
          if($request->payment_request_id == $paymentRequestId){
            $transactionId = $request->payment_id;
            //$order_id = Order::createOrder($address);
            Order::where('id', $orderId)->update(['paymentStatus' => 1,'transactionId'=>$transactionId,'paymentResponse'=>serialize($request->all())]);
            //mail to user about orders
            $updatedOrderDetails= Order::find($orderId);
            Log::info($updatedOrderDetails);
            $mailData =  array('orderDetails' => $updatedOrderDetails,
            'products' => $updatedOrderDetails->orderItems()->get(), );
            //$data = json_decode($orderDetails, true);
            $cdata = array('email' => $body->payment->buyer_email , 'orderId'=>$orderId,);
            Mail::send('emails.mail',$mailData , function ($message) use ($cdata) {
              $message->from('orders@feetnfeel.com', 'FeetnFeel');
              $message->to($cdata['email'])->subject('Your FeetnFeel Order Id #'.$cdata['orderId'].' has been confirmed.');
            });
            //succes blade can event show the order product
            return "payment is success";
          }else{
            //payment id missmatch transaction failed or not found
            return "transaction failed";
          }
        }else{
          //  failed transaction blade
          return "transaction failed";
        }

      }else{
        //payment failed
        return "Payment has failed";
      }
    }else{
      //Some error in transaction
      return "Error in the http call handle it";
    }


    //$body = json_decode($res->getBody());
    //update paymentStatus 	transactionId paymentResponse
    //     array (
    //   'payment_id' => 'MOJO8111005A49527806',
    //   'status' => 'Credit',
    //   'shorturl' => NULL,
    //   'longurl' => 'https://test.instamojo.com/@2713khan/5af07b60623b44c1960038c32c4ca7b4',
    //   'purpose' => 'Order for 8',
    //   'amount' => '100.00',
    //   'fees' => '1.90',
    //   'currency' => 'INR',
    //   'buyer' => 'git@gmail.com',
    //   'buyer_name' => 'Git',
    //   'buyer_phone' => '+919888888999',
    //   'payment_request_id' => '5af07b60623b44c1960038c32c4ca7b4',
    //   'mac' => '0daabd1335df6d86c3a7742cf0b85ebc352157c7',
    // )

  }
  /*
  Creating http call for instamojo API/1.1
  @httpMethod = "GET/POST/"
  @url = "payments/" after the base url "https://test.instamojo.com/api/1.1/"
  @headers = pass extra header e.g ["key"=>"value"] if required exculding [X-Api-Key,X-Auth-Token]
  @bodyType = "form_params(application/x-www-form-urlencoded)/multipart(multipart/form-data)/body(raw data)/"
  @body = passing the body data after setting the type of body
  */
  public function makeHttpCall($httpMethod, $url, $headers, $bodyType, $body)
  {
    $instamojo_url = "https://test.instamojo.com/api/1.1/";
    //Create GuzzleHttp Client with base uri
    $client = new Client([
      'base_uri' => $instamojo_url,
    ]);
    //Set the instamojo API credentials //chnage this to config or env imp
    $instamojo_cred = ["X-Api-Key"=>"a548dba7d6e9a248c5db47b8f75ae749",
    "X-Auth-Token"=> "6367883f83561504447a26ea21192f76"
  ];
  //merging the credentials and headers passed params
  $headers = array_merge($instamojo_cred,$headers);
  //Making request to Insatamojo $res is the response recieved
  $res = $client->request($httpMethod, $url, ['headers'=>$headers, $bodyType=>$body]);
  return $res;
}
}
