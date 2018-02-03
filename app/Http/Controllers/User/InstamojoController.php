
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

class InstamojoController extends Controller
{
  public function __construct()
    {
        $this->middleware('auth');
    }
  public function step1()
  {
    if(auth::check()){
      return redirect()->route('checkout.shipping');
    }
    return redirect('login');
  }
  public function shipping()
  {
    $categories = category::all();
    return view('user.shipping',compact('categories'));
  }
  public function payment()
  {
    return view('user.payment');
  }
  public function storePayment(Request $request)
  {
    $this->validate($request,[
      'address'=>'required',
      'city'=>'required',
      'state'=>'required',
      'zip'=>'required|integer',
      'phone'=>'required|regex:/^[0-9\-\+]{9,15}$/',
    ]);
    //dd($request);
    $domain_url = "http://2972ac0e.ngrok.io";
    //$domain_url = "";
    //"http://127.0.0.1:8000";
    //paramters to be passed to payment take from the order/request
    //dd(Cart::total()*1000);
    //To do before making http request save the order and give status to order table
//add address before order insert into orders
  $address = $request->address.", City: ".$request->city.", state: ".$request->state.", zip:".$request->zip.", Country: ".$request->country;
    $order_id = Order::createOrder($address);


    Auth::user()->address()->create($request->all());
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

      //redirect to the payment interface.
      return redirect($body->payment_request->longurl);
    }else{
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
        return "payment is success";
      }else{
        return "Payment has failed";
      }
    }else{
      return "Error in the http call handle it";
    }
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
