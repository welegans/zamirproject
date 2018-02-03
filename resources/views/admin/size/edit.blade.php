@extends('admin.layout.app')

@section('main-content')
  <div class=" col-md-6 offset-md-3">
    @include('includes.messages')
    <form role="form" class="" action="{{ route('size.update',$size->id)}}" method="post" enctype="multipart/form-data">
      {{csrf_field()}}
      {{ method_field('PUT') }}
      <div class="box-body">
        <div class="form-group">
          <label for="size">Size</label>
          <input type="text" class="form-control" id="size" name="size" value="{{ $size->size }}">
          {{-- <label for="size">Gender</label> --}}
          {{-- <input type="text" class="form-control" id="gender" name="gender" value="{{ $size->gender }}"> --}}
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>

  </div>
@endsection
