@extends('admin.layout.app')
@section('headSection')
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
@endsection
@section('main-content')
  <div class=" col-md-6 offset-md-3">
    @include('includes.messages')
    <form role="form" class="" action="{{ route('category.store')}}" method="post" enctype="multipart/form-data">
      {{csrf_field()}}
      <div class="box-body">
        <div class="form-group">
          <label for="category_name">Category Name</label>
          <input type="text" class="form-control" id="category_name" name="category_name" placeholder="Category Name">
          <label for="catimage">Category Image</label><br>
          <img src="" alt="" id="display_mage" width="150px;">
          <input type="file" name="catimage" id="catimage">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>

  </div>
  <script type="text/javascript">
  function readURL(input) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();

          reader.onload = function (e) {
              $('#display_mage').attr('src', e.target.result);
          }
          reader.readAsDataURL(input.files[0]);
      }
  }
    $("#catimage").change(function(){
      readURL(this);
    });
  </script>
@endsection
