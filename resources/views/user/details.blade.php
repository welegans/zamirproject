@extends('user.layout.app')

@section('main-content')

  <div class="container">
    <div class="details row">
      @include('includes.messages')
      <div class="col-sm-6">
        <div class="box-zoom" id="test1">
          <img class="box-zoom-lazy" src="{{asset('productImages/'.explode(',', $products->image)[0])}}" alt="{{$products->title}}" />
        </div><br>

        <div class="row">
          @foreach (explode(',', $products->image) as $product)
            <div class="col-xs-3">
              <img class="detim" src="{{asset('productImages/'. $product)}}" alt="Image" >
            </div>
          @endforeach
        </div>
      </div>
      <div class="col-sm-6">
      {{-- <form class="" action="{{route('cart.store',$products->id)}}" method="post"> --}}
      <form id="checkForm"  method="post">
        {{csrf_field()}}
        <h2>{{$products->title}}</h2>
        <p>{{$products->subtitle}}</p>
        <p>{{$products->description}}</p>
        <div >
          Size :
          <div class="input-group">
            <select style="margin-left:0.5em;" name="size" class="custom-select size" id="inputGroupSelect02">
              @foreach ($products->sizes as $size)
                <option value="{{ $size->size }}">{{ $size->size }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <br>
        <p><span id="newprice">Rs.{{$products->price}} </span> <span class="line">Rs.{{$products->oldprice}}</span></p>
        <button type="submit" name="check" onclick="submitForm('{{route('cart.store',$products->id)}}')" class="btn btn-warning" value="addCart">
          <span>ADD TO CART</span>
        </button>
        <button type="submit" name="check" onclick="submitForm('{{ route('cart.storeBuy',$products->id)}}')" class="btn btn-danger" value="buyNow">
          <span>BUY NOW</span>
        </button>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript">
$('.detim').on('click',function(){
  var fetched = $(this).attr('src');
  //var fetched="./productImages/img_0.46654600 1516861861.png";
  // alert(fetched);
  $('#test1').css('background-image', 'url("' + fetched + '")');
  console.log(fetched);
  //$("test1").attr("src",fetched);
  // $('.box-zoom-lazy').html('<img src="'+fetched+'">');
});

</script>
<script src="{{asset('js/zoom.js')}}"></script>

<script type="text/javascript">
function submitForm(action) {
  var form = document.getElementById('checkForm');
  form.action = action;
  form.submit();
}
</script>
@endsection
