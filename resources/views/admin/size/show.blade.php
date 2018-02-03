@extends('admin.layout.app')

@section('headSection')
  <link rel="stylesheet" href="{{ asset('datab/DataTables-1.10.16/css/dataTables.bootstrap.css') }}">
  <link rel="stylesheet" href="{{ asset('datab/Responsive-2.2.0/css/responsive.dataTables.min.css') }}">
@endsection

@section('main-content')
  <section class="content">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Size</h3>
        <a class='col-lg-offset-5 btn btn-success' href="{{ route('size.create') }}">Add New</a>
      </div>
      <div class="box-body">
        <div class="box">
          <div class="box-body">
            <table id="tabled" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Sr.No</th>
                  <th>Size</th>
                  {{-- <th>Gender</th> --}}
                  <th>Edit</th>
                  <th>Delete</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($sizes as $size)
                  <tr>
                    <td>{{ $loop->index + 1 }}</td>

                    <td>{{ $size->size }}</td>
                    {{-- <td>{{ $size->gender }}</td> --}}
                    <td><a href="{{ route('size.edit',$size->id) }}"><span class="glyphicon glyphicon-edit"></span></a></td>
                    <td>
                      <form id="delete-form-{{ $size->id }}" method="post" action="{{ route('size.destroy',$size->id) }}" style="display: none">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                      </form>
                      <a href="" onclick="
                      if(confirm('Are you sure, You Want to delete this?'))
                      {
                        event.preventDefault();
                        document.getElementById('delete-form-{{ $size->id }}').submit();
                      }
                      else{
                        event.preventDefault();
                      }" ><span class="glyphicon glyphicon-trash"></span></a>
                    </td>
                  </tr>
                </tr>
              @endforeach
            </tbody>
            <tfoot>
              <tr>
                <th>S.No</th>
                <th>Size</th>
                {{-- <th>Gender</th> --}}
                <th>Edit</th>
                <th>Delete</th>
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
