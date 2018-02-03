@extends('user.layout.app')

@section('main-content')
  <div class="container cart" style="padding:4em 1em">
    <h3>My Cart </h3>
    <h4>Total : Rs.{{Cart::total()}}</h4>
    <div class="row ">
      <hr><hr>
      @forelse ($cartItems as $cartItem)
        <div class="col-sm-1"></div>
        <div class="col-sm-4 cartim">
          {{-- <img src="{{asset('images/Desert.jpg')}}" alt=""> --}}
          <img  src="{{$cartItem->options->image}}" alt="{{ $cartItem->name}}" >
          {{-- <input type="hidden" name="image" value="{{asset('productImages/' .explode(',', $cartItem->options->image)[0])}}"> --}}
        </div>
        <div class="col-sm-6">
          <h3>{{$cartItem->name}}</h3>
          <p>Rs.{{$cartItem->price}}</p>
          {{-- <p>{{$cartItem->options->size}}</p> --}}
          @include('includes.messages')
          <form class="" action="{{route('cart.update',$cartItem->rowId)}}" method="post">
            {{csrf_field()}}
            {{ method_field('PATCH') }}
            <div class="input-group">
              <input type="hidden" name="image" value="{{$cartItem->options->image}}">
              <input  type="text" class="form-control"  name="qty" value="{{$cartItem->qty}}" >
              <select style="margin-left:0.5em;" name="size" class="custom-select size" id="inputGroupSelect02">
                <option value="{{$cartItem->options->size}}" selected>{{$cartItem->options->size}}</option>
                @foreach (App\Product::find($cartItem->id)->sizes()->get() as $sizeDetails)
                  @continue($sizeDetails->size == $cartItem->options->size)
                  <option value="{{$sizeDetails->size}}">{{$sizeDetails->size}}</option>
                @endforeach
              </select>
              <input style="margin-left:1em;" type="submit" class="btn btn-sm btn-primary" name="" value="UPDATE">
            </div>
          </form>
          <br>
        </div>
        <div class="col-sm-1">
          @include('includes.messages')
          <form action="{{route('cart.destroy',$cartItem->rowId)}}" method="post">
            {{csrf_field()}}
            {{method_field('DELETE')}}
            <div class="input-group">
              <button type="submit" name="" value="Delete" class="btn btn-sm btn-danger"><i class="fa fa-lg fa-trash-o" aria-hidden="true"></i></button>
            </div>
          </form>
        </div>

      @empty
        <div style="text-align:left">
          <h4 >Your cart is empty</h4><br>
          <h5>Go to <strong><a style="color:#f1f1f1;" href="{{ route('home')}}"> HOME</a></strong></h5>
        </div>

      @endforelse
      @if (Cart::count()!=0)
        <a href="{{route('checkout.shipping')}}" class="btn btn-warning">CHECKOUT</a>

      @endif

    </div>

  </div>
@endsection
