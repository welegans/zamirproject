@extends('user.layout.app')

@section('main-content')
  <div class="container profile">
    <h1>Profile</h1>
    <div>
      <h3>Welcome {{$user->name}}</h3>
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
          <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" id="{{"edit_".$address->id}}" data-target="#myModal">Edit</button>
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
            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
          </form>
        </div>
        <hr>
      @endforeach

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

@endsection
