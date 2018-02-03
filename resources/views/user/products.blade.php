@extends('user.layout.app')

@section('main-content')
  <div class="container-fluid">
    <div class="row">
      @include('includes.messages')
      <div class="col-sm-2 sidesearch">
        <ul>
          {{-- <p>Men</p> --}}
          @foreach ($categories as $category)
            <li><a href="{{ route('category',$category->category_name) }}">{{ $category->category_name }}</a>
            </li>
          @endforeach

        </ul>

      </div>
      <div class="col-sm-10 products">
        <h2></h2>
        <div class="row">
          @forelse($products as $product)
            <div class="col-sm-3">
              <div class="card">
                <div class="card-block">
                  <a href="{{route('details',$product->id)}}" >
                    <img src="{{asset('productImages/'.explode(',', $product->image)[0])}}" alt="Image" width="150px">
                    {{-- <img src="{{asset('productImages/' .$product->image)}}" alt="{{ $product->title}}" > --}}
                    <h5 class="card-title">{{ $product->title}}</h5>
                    <p >{{ $product->subtitle}}</p>
                    <p id="newprice">Rs.{{ $product->price}}</p><p id="offer">Rs.{{ $product->oldprice}}</p></a>
                    {{-- <p><a href="{{route('details',$product->id)}}" class="pull-right">Read More...</a></p> --}}
                    {{-- <div class="add">
                    <a href="{{route('cart.store',$product->id)}}">
                    <button type="button" name="button" class="btn btn-warning">
                    Add To Cart</button></a>
                  </div> --}}
                </div>
              </div>
            </div>
          @empty
            <h3>No products</h3>
          @endforelse
        </div>
      </div>
    </div>

  </div>
@endsection
