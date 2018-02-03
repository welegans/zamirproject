@extends('admin.layout.app')

@section('main-content')
  <div class=" col-md-6 offset-md-3">
    @include('includes.messages')
    <form role="form" class="" action="{{ route('gender.update',$gender->id)}}" method="post" enctype="multipart/form-data">
      {{csrf_field()}}
      {{ method_field('PUT') }}
      <div class="box-body">

        <div class="form-group">
          <label for="gender_name">Gender Name</label>
          <input type="text" class="form-control" id="gender_name" name="gender_name" value="{{ $gender->gender_name }}">
          {{-- <label for="gender_name">Gender</label> --}}
          {{-- <input type="text" class="form-control" id="gender" name="gender" value="{{ $gender->gender }}"> --}}
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>

  </div>
@endsection
