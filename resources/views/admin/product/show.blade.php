@extends('admin.layout.app')

@section('headSection')
  <link rel="stylesheet" href="{{ asset('datab/DataTables-1.10.16/css/dataTables.bootstrap.css') }}">
  <link rel="stylesheet" href="{{ asset('datab/Responsive-2.2.0/css/responsive.dataTables.min.css') }}">
@endsection
@section('main-content')
  <!-- Content Wrapper. Contains page content -->
  <section class="content">

    <!-- Default box -->
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Product</h3>
        <a class='col-lg-offset-5 btn btn-success' href="{{ route('products.create') }}">Add New</a>
        {{-- <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
        <i class="fa fa-minus"></i></button>
        <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
        <i class="fa fa-times"></i></button>
      </div> --}}
    </div>
    <div class="box-body">
      <div class="box">
          <div class="box-body">
          <table id="tabled" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Sr.No</th>
                <th>Title</th>
                <th>Sub Title</th>
                {{-- <th>Gender</th> --}}
                <th>Price</th>
                <th>Brand</th>
                <th>Category</th>
                <th>Created At</th>
                {{-- @can('products.update',Auth::user()) --}}
                <th>Edit</th>
                {{-- @endcan --}}
            {{--     @can('products.delete', Auth::user()) --}}
                {{-- <th>Delete</th> --}}
                {{-- @endcan --}}
              </tr>
            </thead>
            <tbody>
              @foreach ($products as $product)
                <tr>
                  <td>{{ $loop->index + 1 }}</td>
                  <td>{{ $product->title }}</td>
                  <td>{{ $product->subtitle }}</td>
                  {{-- <td>{{ $product->gender }}</td> --}}
                  <td>{{ $product->price }}</td>
                  <td>{{ $product->brand }}</td>
                  <td>
                    @foreach (App\Product::find($product->id)->categories()->get() as $categoryDetails)
                      {{$categoryDetails->category_name}}
                      <br>
                    @endforeach
                  </td>
                  <td>{{ $product->created_at }}</td>

                  {{-- @can('products.update',Auth::user()) --}}
                  <td><a href="{{ route('products.edit',$product->id) }}"><span class="glyphicon glyphicon-edit"></span></a></td>
                  {{-- @endcan

                  @can('products.delete', Auth::user()) --}}
                  {{-- <td>
                    <form id="delete-form-{{ $product->id }}" method="post" action="{{ route('products.destroy',$product->id) }}" style="display: none">
                      {{ csrf_field() }}
                      {{ method_field('DELETE') }}
                    </form>
                    <a href="" onclick="
                    if(confirm('Are you sure, You Want to delete this?'))
                    {
                      event.preventDefault();
                      document.getElementById('delete-form-{{ $product->id }}').submit();
                    }
                    else{
                      event.preventDefault();
                    }" ><span class="glyphicon glyphicon-trash"></span></a>
                  </td> --}}
                  {{-- @endcan --}}
                </tr>
              @endforeach
            </tbody>
            <tfoot>
              <tr>
                <th>Sr.No</th>
                <th>Title</th>
                <th>Sub Title</th>
                {{-- <th>Gender</th> --}}
                <th>Price</th>
                <th>Brand</th>
                <th>Category</th>
                <th>Created At</th>
                {{-- @can('products.update',Auth::user()) --}}
                <th>Edit</th>
                {{-- @endcan
                @can('products.delete', Auth::user()) --}}
                {{-- <th>Delete</th> --}}
                {{-- @endcan --}}
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
