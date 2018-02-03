@extends('admin.layout.app')

@section('headSection')
  <link rel="stylesheet" href="{{ asset('datab/DataTables-1.10.16/css/dataTables.bootstrap.css') }}">
  <link rel="stylesheet" href="{{ asset('datab/Responsive-2.2.0/css/responsive.dataTables.min.css') }}">
@endsection

@section('main-content')
  <section class="content">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Orders</h3>
        {{-- <a class='col-lg-offset-5 btn btn-success' href="{{ route('orders.create') }}">Add New</a> --}}
      </div>
      <div class="box-body">
        <div class="box">
          <div class="box-body">
            <table id="tabled" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Order id</th>
                  <th>Product Title (qty)</th>
                  {{-- <th>Gender</th> --}}
                  {{-- <th>Quantity</th> --}}
                  <th>Price</th>
                  <th>Size</th>
                  <th>User</th>
                  <th>Address</th>
                  <th>Order Date</th>
                  <th>Payment Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($orders as $order)
                  @foreach($order->orderItems as $item)
                    {{-- <h4>Order by {{$order->user->name}} <br>Total Price {{$order->total}}</h4> --}}
                    <tr>
                      {{-- <td>{{ $loop->index + 1 }}</td> --}}
                      <td>{{ $order->id}}</td>
                      <td>{{$item->title}} ({{$item->pivot->qty}})</td>
                      <td>{{$item->pivot->total}}</td>
                      <td>{{$item->pivot->size}}</td>
                      <td>{{$order->user->name}} - {{$order->user->id}}</td>
                      <td>{{$order->address}}</td>
                      <td>{{$order->updated_at}}</td>
                      <td>  @if ($order->paymentStatus == 1)
                        Paid
                      @else
                        Not Paid
                      @endif
                    </td>
                    <td><form  action="{{route('toggle.deliver',$order->id)}}" method="POST"
                      id="deliver-toggle">
                      {{csrf_field()}}
                      <label for="delivered">Delivered</label>
                      <input type="checkbox" value="1" name="delivered" {{$order->delivered==1?"checked":"" }}>
                      <input type="submit" class="btn btn-primary btn-sm" value="SUBMIT">
                    </form></td>
                  </tr>
                @endforeach
              @endforeach

            </tbody>
            <tfoot>
              <tr>
                <th>Order id</th>
                <th>Product Title (qty)</th>
                {{-- <th>Gender</th> --}}
                {{-- <th>Quantity</th> --}}
                <th>Price</th>
                <th>Size</th>
                {{-- <th>Total</th> --}}
                <th>User</th>
                <th>Address</th>
                <th>Order Date</th>
                <th>Payment Status</th>
                <th>Action</th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
@section('footerSection')
  <script src="{{ asset('datab/DataTables-1.10.16/js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('datab/DataTables-1.10.16/js/dataTables.bootstrap.min.js') }}"></script>
  <script src="{{ asset('datab/Responsive-2.2.0/js/dataTables.responsive.min.js') }}"></script>
  <script>
  $(function () {
    $("#tabled").DataTable();
  });
  $('#tabled').DataTable( {
    responsive: true
  } );
  </script>
@endsection
