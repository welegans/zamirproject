@extends('user.layout.app')

@section('main-content')
  <div class="usersor container">
    <h2>Your orders</h2>
    {{-- {{$user->name}} --}}
    @foreach ($orders as $order)
      <p>Placed on {{$order->updated_at}}</p>
      {{-- <p>Not delivered yet</p> --}}
      <div class="row">
        @foreach (App\Order::find($order->id)->orderItems()->get() as $product)
          <div class="col-sm-3">
            <img src="{{asset('productImages/'.explode(',', $product->image)[0])}}" alt="{{$product->title}}" width="200">
            <p>{{$product->title}}</p>
            <p>{{$product->subtitle}}</p>
            <p>Rs.{{$product->pivot->total}}</p>
          </div>
        @endforeach
      </div>
      <p>Shipping address :  <br></p>
      <p>
        {{$order->address}}
      </p>
      <h5>Order total : Rs.{{$order->total}}</h5>
      <hr>
    @endforeach
  </div>

</div>


@endsection
