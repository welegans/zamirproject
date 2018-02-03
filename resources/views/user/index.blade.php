@extends('user.layout.app')
@section('main-content')

  <div id="carousel1" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
      <li data-target="#carousel1" data-slide-to="0" class="active"></li>
      <li data-target="#carousel1" data-slide-to="1"></li>
      <li data-target="#carousel1" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner" role="listbox">
      <div class="carousel-item active">
        <img class="d-block img-fluid" src="{{ asset('images/slid1.jpg')}}" alt="First slide">
      </div>
      <div class="carousel-item">
        <img class="d-block img-fluid" src="{{ asset('images/slid2.jpg')}}" alt="First slide">
      </div>
      <div class="carousel-item">
        <img class="d-block img-fluid" src="{{ asset('images/slid3.jpg')}}" alt="First slide">
      </div>
    </div>
  </div>
  @include('includes.messages')
  <h2>This website is under construction.</h2>
  <div class="container-fluid">
    <div class="cats row">
      @forelse ($categories as $category)
        <div class="col-6 col-sm-4 catout">
          <a href="{{ route('category',$category->category_name) }}">
            <div class="catsin" style="background: url('{{asset('categories/'.$category->catimage)}}') center no-repeat;background-size: cover;">
              <div class="overlay">
                <div class="text"><h3>  {{ $category->category_name }}</h3></div>
              </div>
            </div></a>
          </div>
        @empty
          <h3>No products</h3>
        @endforelse
      </div>
    </div>
    <div class="">
      <div id="section1">
        <h3>New Arrivals</h3>
        <div class="row products">
          @forelse($products as $product)
            <div class="col-sm-3">
              <div class="card">
                <div class="card-block">
                  <a href="{{route('details',$product->id)}}" >
                    {{-- <img src="{{asset('storage/app/' .$product->image)}}" alt="{{ $product->title}}" > --}}
                    <img src="{{asset('productImages/'.explode(',', $product->image)[0])}}" alt="Image" width="150px">

                    <h5 class="card-title">{{ $product->title}}</h5>
                    <p >{{ $product->subtitle}}</p>
                    <p id="newprice">Rs.{{ $product->price}}</p><p id="offer">Rs.{{ $product->oldprice}}</p></a>
                  </div>
                </div>
              </div>
            @empty
              <h3>No products</h3>
            @endforelse
            {{-- @forelse ($categories as $category)
            <div class="col-sm-4">
            <a href="{{ route('category',$category->category_name) }}"><div class="card">
            <div class="card-block">
            <img src="{{asset('storage/app/' .$category->image)}}" alt="image name" >
            <h5 class="card-title">{{ $category->category_name }}</h5>
          </div>
        </div></a>
      </div>
    @empty
    <h3>No products</h3>
  @endforelse --}}
</div>
</div></div>
@endsection
