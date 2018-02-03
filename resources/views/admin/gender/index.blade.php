@extends('admin.layout.app')

@section('main-content')
  <div class=" col-md-6 offset-md-3">
    @include('includes.messages')
    <form role="form" class="" action="{{ route('gender.store')}}" method="post" enctype="multipart/form-data">
      {{csrf_field()}}
      <div class="box-body">
        <div class="form-group">
          <label for="gender_name">Gender Name</label>
          <input type="text" class="form-control" id="gender_name" name="gender_name" placeholder="Gender Name">
        {{-- <br>  <label for="gender">Gender</label> --}}
          {{-- <input type="text" class="form-control" id="gender" name="gender" placeholder="Gender"> --}}
          {{-- <select class="form-control" id="gender" name="gender" placeholder="Gender">
            <option value="male">Male</option>
            <option value="male">Female</option>
          </select> --}}
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>

  </div>
@endsection
