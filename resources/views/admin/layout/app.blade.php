<!DOCTYPE html>
<html>
@include('admin.layout.head')
<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">

    @include('admin.layout.header')
    <!-- Left side column. contains the logo and sidebar -->
    @include('admin.layout.sidebar')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      @section('main-content')

      @show
      
    </div>
    <!-- /.content-wrapper -->
    <div class="control-sidebar-bg"></div>
    {{--
    <div class="col-sm-6" style="width:200px;height:200px;background-color:yellow;background-image: url(@yield('bg-img'))">
    <img src="{{asset($product->image)}}" alt="">
  </div> --}}
  @include('admin.layout.footer')

</div>

</body>
</html>
