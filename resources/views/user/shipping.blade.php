@extends('user.layout.app')

@section('main-content')
  <div class="container">
    <div class="shipping">
      <h3>Shipping Info</h3>
      {{-- @include('includes.messages')
      <form  action="{{route('address.store')}}" method="post">
      {{csrf_field()}}
      <div class="row">
      <div class="col-sm-6">
      <fieldset class="form-group">
      <label for="address">Address</label>
      <input type="text" class="form-control" name="address" id="address" placeholder="Address">
    </fieldset>
    <fieldset class="form-group">
    <label for="city">City</label>
    <input type="text" class="form-control" name="city" id="city" placeholder="City">
  </fieldset>
  <fieldset class="form-group">
  <label for="state">State</label>
  <input type="text" class="form-control" name="state" id="state" placeholder="State">
</fieldset>
</div>
<div class="col-sm-6">
<fieldset class="form-group">
<label for="zip">Zip</label>
<input type="text" class="form-control" name="zip" id="zip" placeholder="Zip">
</fieldset>
<fieldset class="form-group">
<label for="country">Country</label>
<input type="text" class="form-control" name="country" id="country" placeholder="Country">
</fieldset>
<fieldset class="form-group">
<label for="phone">Phone</label>
<input type="text" class="form-control" name="phone" id="phone" placeholder="Phone">
</fieldset>
</div>
</div><br>
<input id="check" type="submit" class="btn btn-danger" value="Add Address">
</form> --}}
@foreach ($orders as $order)
  <p>Placed on {{$order->updated_at}}</p>
  {{-- <p>Not delivered yet</p> --}}
  <div class="row">
    @foreach (App\Order::find($order->id)->orderItems()->get() as $product)
      <div class="col-sm-3">
        <img src="{{$product->image}}" alt="{{$product->title}}">
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
@foreach ($addresses as $address)
  <label for="address">Address</label>
  <p>
    <span id="{{"address_".$address->id}}">{{$address->address}}</span>,
    <span id="{{"state_".$address->id}}">{{$address->state}}</span>,
    <span id="{{"city_".$address->id}}">{{$address->city}}</span>,
    <span id="{{"zip_".$address->id}}">{{$address->zip}}</span>,
    <span id="{{"country_".$address->id}}">{{$address->country}}</span>,
    <span id="{{"phone_".$address->id}}">{{$address->phone}}</span>
  </p>
  <form action="{{route('storePayment',$address->id)}}" method="POST">
    {{csrf_field()}}
    <button type="submit" class="btn btn-sm btn-primary">Deliver to this Address</button><br>
  </form>
  <button type="button" id="edd" class="btn btn-warning btn-sm" data-toggle="modal" id="{{"edit_".$address->id}}" data-target="#myModal">Edit</button>
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit Address</h4>
        </div>
        <div class="modal-body">
          <form id="profile-form" action="{{ route('addressUpdate')}}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input type="hidden" name="id" id="id">
            <input type="text" class="form-control" name="address" id="address" placeholder="Address" >
            <input type="text" class="form-control" name="city" id="city" placeholder="City" >
            <input type="text" class="form-control" name="state" id="state" placeholder="State" >
            <input type="text" class="form-control" name="zip" id="zip" placeholder="Zip" >
            <input type="text" class="form-control" name="country" id="country" placeholder="Country" >
            <input type="text" class="form-control" name="phone" id="phone" placeholder="Phone">
            <div class="modal-footer">
              <button type="submit" class="btn btn-default"  >Save</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  @include('includes.messages')
  {{-- <button type="button" class="btn btn-danger btn-sm">Delete</button> --}}
  <form action="{{route('address.destroy',$address->id)}}" method="POST">
    {{csrf_field()}}
    {{method_field('DELETE')}}
    <button type="submit" id="edd" class="btn btn-sm btn-danger">Delete</button>
    <br>
  </form>

  <hr>
@endforeach
{{-- <a href="{{route('checkout.shipping')}}" class="btn btn-sm btn-warning"></a> --}}
<button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal2">Add New</button>
<div class="modal fade" id="myModal2" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Address</h4>
      </div>
      <div class="modal-body">
        <form id="profile-form" action="{{ route('address.store')}}" method="POST" enctype="multipart/form-data">
          {{ csrf_field() }}
          <input type="hidden" name="id" id="id">
          <input type="text" class="form-control" name="address" id="address" placeholder="Address" >
          <input type="text" class="form-control" name="city" id="city" placeholder="City" >
          <input type="text" class="form-control" name="state" id="state" placeholder="State" >
          <input type="text" class="form-control" name="zip" id="zip" placeholder="Zip" >
          <input type="text" class="form-control" name="country" id="country" placeholder="Country" >
          <input type="text" class="form-control" name="phone" id="phone" placeholder="Phone">
          <div class="modal-footer">
            <button type="submit" class="btn btn-warning"  >Save</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
</div>
</div>

<script type="text/javascript">
$(":button").click(function(){
  var button_id = $(this).attr("id");
  if(button_id && button_id.includes("edit_")){
    var id = button_id.split("_")[1];
    $("#id").val(id);
    $("#address").val($("#address_"+id).html());
    $("#city").val($("#city_"+id).html());
    $("#state").val($("#state_"+id).html());
    $("#zip").val($("#zip_"+id).html());
    $("#country").val($("#country_"+id).html());
    $("#phone").val($("#phone_"+id).html());
    //$(".phone").val();
  }
});
</script>
</div>
</div>

@endsection
