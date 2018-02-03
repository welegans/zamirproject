
<div class="mailed" style="border:1px solid black;padding:1em;">
  <div class="header" style="background-color: #07ad9d;padding: 1em;color: #fff;">
    <h2>Feet N Feel</h2><br>
    <a style="padding:0.5em;color:gray;" href="feetnfeel.com">www.feetnfeel.com</a>
  </div>
  <h3 style="text-align: center;padding:0.5em;">Order Confirmation</h3>
  <p>Placed on {{$orderDetails->updated_at}}</p>
  {{-- <h4>Hello {{$orderDetails->buyer_name}}!</h4> --}}
  <hr>

  @foreach ($products as $product)
    <p style="font-size:1.5em;"><strong>{{$product->title}}</strong>({{$product->pivot->qty}})</p>
    <p>{{$product->subtitle}}</p>
    <p>Rs.{{$product->pivot->total}}</p>

  @endforeach
<h5 style="font-size:1.5em;">Order total : Rs.{{$orderDetails->total}}</h5>
  <p style="font-size:1.5em;">Delivery address :  <br></p>
  <p>
    {{$orderDetails->address}}
  </p>

</div>
