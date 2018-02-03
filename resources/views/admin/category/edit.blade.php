@extends('admin.layout.app')

@section('main-content')
  <div class=" col-md-6 offset-md-3">
    @include('includes.messages')
    <form role="form" class="" action="{{ route('category.update',$category->id)}}" method="post" enctype="multipart/form-data">
      {{csrf_field()}}
      {{ method_field('PUT') }}
      <div class="box-body">
        <div class="form-group">
          <label for="category_name">Category Name</label>
          <input type="text" class="form-control" id="category_name" name="category_name" value="{{ $category->category_name }}">
          <label for="catimage">Category Image</label><br>
          <img src="{{asset('categories/' .$category->catimage)}}" alt="{{$category->category_name}}" width="150px;">
          <input type="file" name="catimage" id="catimage" value="{{$category->catimage}}">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>
  </div>
@endsection
