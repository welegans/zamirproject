@extends('admin.layout.app')

@section('headSection')
  <link rel="stylesheet" href="{{ asset('admin/bower_components/select2/dist/css/select2.min.css') }}">

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
{{-- @section('bg-img',Storage::disk('local')->url($product->image)) --}}

@section('main-content')
  <div class="product_details col-md-6 offset-md-3">

    @include('includes.messages')
    <form action="{{ route('products.update',$product->id) }}" method="post" enctype="multipart/form-data">
      {{ csrf_field() }}
      {{ method_field('PATCH') }}
      <div class="box-body container">
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <label for="title">Product title</label>
              <input type="title" class="form-control" id="title" name="title" placeholder="Product title" value="{{ $product->title }}">
            </div>
            <div class="form-group">
              <label for="subtitle">Subtitle</label>
              <input type="subtitle" class="form-control" id="subtitle" name="subtitle" placeholder="Subtitle" value="{{ $product->subtitle }}">
            </div>
            <div class="form-group">
              <label for="description">Description</label>
              <input type="description" class="form-control" id="description" name="description" placeholder="Description" value="{{ $product->description }}">
            </div>
            <div class="form-group">
              <label for="brand">Brand</label>
              <input type="brand" class="form-control" id="brand" name="brand" placeholder="Brand" value="{{ $product->brand }}">
            </div>
            <div class="form-group" id="image_preview">
              {{-- <label for="image">Image</label> --}}
              @foreach (explode(",", $product->image) as $imagepath)
                {{-- {{asset(\Storage::url($imagepath))}} --}}
              <span class='singleImage form-group'>
                <img src="{{asset('productImages/'.$imagepath)}}" alt="Image" width="150px">
                <input type="hidden" name="oldImage[]" value="{{asset('images/'.$imagepath)}}">
                <i class='fa fa-times-circle delete_image' aria-hidden='true'></i>

              </span>
              @endforeach
              {{-- <input type="file" id="image" name="image" required> --}}
            </div>

            <div class="checkbox">
              <label>
                <input type="checkbox" name="status" value="1" @if ($product->status == 1)
                  {{'checked'}}
                @endif> Publish
              </label>
            </div>
          </div>

          <div class="col-sm-6">
            <div class="form-group">
              <label for="oldprice">Old Price</label>
              <input type="oldprice" class="form-control" id="oldprice" name="oldprice" placeholder="Old Price" value="{{ $product->oldprice }}" required>
            </div>
            <div class="form-group">
              <label for="price">Price</label>
              <input type="price" class="form-control" id="price" name="price" placeholder="Price" value="{{ $product->price }}" required>
            </div>
            <div class="form-group" style="margin-top:18px;">
              <label>Select Category</label>
              <select class="form-control select2 select2-hidden-accessible" multiple="" data-placeholder="Select a Category" style="width: 100%;" tabindex="-1" aria-hidden="true" name="categories[]" required>
                @foreach ($categories as $category)
                  <option value="{{ $category->id }}"
                    @foreach ($product->categories as $productCategory)
                      @if ($productCategory->id == $category->id)
                        selected
                      @endif
                    @endforeach
                    >{{ $category->category_name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group" style="margin-top:18px;">
                <label>Select Size</label>
                <select class="form-control select2 select2-hidden-accessible" multiple="" data-placeholder="Select Size" style="width: 100%;" tabindex="-1" aria-hidden="true" name="sizes[]" required>
                  @foreach ($sizes as $size)
                    <option value="{{ $size->id }}"
                      @foreach ($product->sizes as $productSize)
                        @if ($productSize->id == $size->id)
                          selected
                        @endif
                      @endforeach
                      >{{ $size->size }}</option>
                    @endforeach
                  </select>
                </div>
              <div class="form-group" style="margin-top:18px;">
                <label>Select Gender</label>
                <select name="gender" id="gender" value="{{$product->gender}}" class="form-control select2 select2-hidden-accessible" multiple="" style="width: 100%;" tabindex="-1" aria-hidden="true">
                  <option value="{{$product->gender}}" selected>{{$product->gender}}</option>
                  <option value="male">Male</option>
                  <option value="female">Female</option>

                </select>
              </div>
            </div>
          </div>
          {{-- <img src="{{asset($product->image)}}" alt="{{$product->title}}" width="30%" width="30%"> --}}
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
    function getBase64(file) {
      return new Promise((resolve, reject) => {
        const reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = () => resolve(reader.result);
        reader.onerror = (error) => reject(error);
      });
    };
    $(document).ready(function() {
      $(".select2").select2();
      $('#image_preview').on('click','.delete_image', function(){
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
    });
    </script>
  @endsection
