@extends('admin.layout.app')

@section('headSection')
  <link rel="stylesheet" href="{{ asset('datab/datatables/dataTables.bootstrap.css') }}">
@endsection

@section('main-content')
  <!-- Content Wrapper. Contains page content -->
  <section class="content">

    <!-- Default box -->
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Gender</h3>
        <a class='col-lg-offset-5 btn btn-success' href="{{ route('gender.create') }}">Add New</a>
        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
            <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
            </div>
          </div>
          <div class="box-body">
            <div class="box">
              <div class="box-header">
                <h3 class="box-title">Data Table With Full Features</h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <table id="tabled" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>S.No</th>
                      <th>Gender Name</th>
                      {{-- <th>Gender</th> --}}
                      <th>Edit</th>
                      <th>Delete</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($genders as $gender)
                      <tr>
                        <td>{{ $loop->index + 1 }}</td>

                        <td>{{ $gender->gender_name }}</td>
                        {{-- <td>{{ $gender->gender }}</td> --}}
                        <td><a href="{{ route('gender.edit',$gender->id) }}"><span class="glyphicon glyphicon-edit"></span></a></td>
                        <td>
                          <form id="delete-form-{{ $gender->id }}" method="post" action="{{ route('gender.destroy',$gender->id) }}" style="display: none">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                          </form>
                          <a href="" onclick="
                          if(confirm('Are you sure, You Want to delete this?'))
                          {
                            event.preventDefault();
                            document.getElementById('delete-form-{{ $gender->id }}').submit();
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
                    <th>Gender Name</th>
                    {{-- <th>Gender</th> --}}
                    <th>Edit</th>
                    <th>Delete</th>
                  </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          Footer
        </div>
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->

  @endsection
  @section('footerSection')
    <script src="{{ asset('datab/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('datab/datatables/dataTables.bootstrap.min.js') }}"></script>
    <script>
    $(function () {
      $("#tabled").DataTable();
    });
  </script>
@endsection
