@extends('admin.layout.app')

@section('headSection')
  <link rel="stylesheet" href="{{ asset('admin/bower_components/select2/dist/css/select2.min.css') }}">
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

  <style type="text/css">
  input[type=file]{
    display: inline;
  }
  #image_preview{
    padding: 10px;
  }
  .img_product{
    width: 150px;
    padding: 5px;
  }

  </style>
@endsection

@section('main-content')
  <div class="product_details col-md-6 offset-md-3">
    @include('includes.messages')
    <form action="{{ route('products.store')}}" method="post" enctype="multipart/form-data">
      {{csrf_field()}}
      <div class="box-body container">
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              {{-- <label for="title">Product title</label> --}}
              <input type="text" class="form-control" id="title" name="title" placeholder="Product title">
            </div>
            <div class="form-group">
              {{-- <label for="subtitle">Subtitle</label> --}}
              <input type="text" class="form-control" id="subtitle" name="subtitle" placeholder="Subtitle">
            </div>
            <div class="form-group">
              {{-- <label for="description">Description</label> --}}
              <input type="text" class="form-control" id="description" name="description" placeholder="Description">
            </div>
            <div class="form-group">
              {{-- <label for="brand">Brand</label> --}}
              <input type="text" class="form-control" id="brand" name="brand" placeholder="Brand">
            </div>


            <div class="checkbox pull-left form-group">
              <label>
                <input type="checkbox" name="status" value="1"> Publish
              </label>
            </div>
            {{-- <div class="form-group">
            <label for="gender">Gender</label>
            <input type="text" class="form-control" id="gender" name="gender" placeholder="Gender">
          </div> --}}
        </div>

        <div class="col-sm-6">
          <div class="form-group">
            {{-- <label for="oldprice">Old Price</label> --}}
            <input type="text" class="form-control" id="oldprice" name="oldprice" placeholder="Old Price" required>
          </div>
          <div class="form-group">
            {{-- <label for="price">Price</label> --}}
            <input type="text" class="form-control" id="price" name="price" placeholder="Price" required>
          </div>
          <div class="form-group" style="margin-top:18px;">
            {{-- <label>Select Category</label> --}}
            <select class="form-control select2 select2-hidden-accessible" multiple="" data-placeholder="Select a Category" style="width: 100%;" tabindex="-1" aria-hidden="true" name="categories[]" required>
              @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->category_name }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group" style="margin-top:18px;">
            {{-- <label>Select Gender</label> --}}
            <select name="gender" id="gender" class="form-control select2 select2-hidden-accessible" multiple="" data-placeholder="Select Gender" style="width: 100%;" tabindex="-1" aria-hidden="true" >
              <option value="male">Male</option>
              <option value="female">Female</option>
            </select>
          </div>
          <div class="form-group" style="margin-top:18px;">
            <select class="form-control select2 select2-hidden-accessible" multiple="" data-placeholder="Select Size" style="width: 100%;" tabindex="-1" aria-hidden="true" name="sizes[]" required>
              @foreach ($sizes as $size)
                <option value="{{ $size->id }}">{{ $size->size }}</option>
              @endforeach
            </select>
          </div>

          <div  class="form-group" id="image_preview"></div>
        </div>
      </div>

      <button type="submit" class="btn btn-primary">Submit</button>
    </div>
  </form>
  <div class="form-group">
    <label for="image">Image</label>
    {{-- <input type="file" id="image" name="image[]" multiple required> --}}
    <form action="{{ route('images.upload') }}" method="post" enctype="multipart/form-data">
      {{ csrf_field() }}
      <input type="file" id="image" name="image[]" multiple/>
      {{-- <input type="submit" class="btn btn-success" name='submitImage' value="Upload Image"/> --}}
    </form>
  </div>
</div>
@endsection

@section('footerSection')
  <script src="{{ asset('admin/bower_components/select2/dist/js/select2.full.min.js') }}"></script>
  <script>
  $(document).ready(function() {
    $(".select2").select2();
  });
</script>
<script type="text/javascript">
function getBase64(file) {
  return new Promise((resolve, reject) => {
    const reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = () => resolve(reader.result);
    reader.onerror = (error) => reject(error);
  });
};



$('#image_preview').on('click','.delete_image',function(){
  //alert("Remove"+$(this).attr('src'));
  //$(this).children().remove();
  $(this).parent().remove();
});
$("#image").change(function(){
  //$('#image_preview').html("");
  var total_file=document.getElementById("image").files;
  for(var i=0;i<total_file.length;i++)
  {
      getBase64(total_file[i]).then(function(image64data){
            $('#image_preview').append("<span class='singleImage form-group'><img src='"+image64data+"' class='img_product' alt='image'><i class='fa fa-times-circle delete_image' aria-hidden='true'></i>  <input type='hidden' value='"+image64data+"' name='uimage[]'></span>");
            //<input type='image' src='"+image64data+"' class='img_product' alt='image'>
      });

//<input type="image" src='"+URL.createObjectURL(event.target.files[i])+"' alt="image">
//<img src='"+URL.createObjectURL(event.target.files[i])+"'>
  }
});

// $('form').ajaxForm(function()
// {
//   alert("Uploaded SuccessFully");
// });
$(".singleImage").click(function(){
alert('delete');
  });
</script>
@endsection
