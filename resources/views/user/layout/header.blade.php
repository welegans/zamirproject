<nav class="navbar sticky-top navbar-toggleable-md navbar-light" style="background-color:white;">
  <button class="navbar-toggler navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <a class="navbar-brand" href="{{ route('home')}}">Feet N Feel</a>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="{{ route('home')}}">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">About</a>
      </li>
      {{-- <li class="nav-item">
      <a class="nav-link " href="{{ route('product')}}">Products</a>
    </li> --}}
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="{{ route('product')}}" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Products
      </a>
      <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
        <a href="#">
          {{--class="dropdown-item" ---- For Her --}}
          <ul class="dropcat">
            @foreach ($categories as $category)
              <li><a href="{{ route('category',$category->category_name) }}">{{ $category->category_name }}</a>
              </li>
            @endforeach
          </ul>
        </a>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link " href="#">Contact</a>
    </li>
  </ul>
  <div class="search">
    <form class="form-inline">
    </a>
    <input class="form-control" type="text" placeholder="&#xF002; Search" style="font-family:Arial, FontAwesome"> 
    {{-- <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button> --}}
</form>
</div>
<ul class="navbar-nav">
  <li class="nav-item dropdown" >
    @guest
      <a class="nav-link dropdown-toggle" href="#"
      id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      Login
    </a>
    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
      <a class="dropdown-item" href="{{ route('login') }}">Login</a>
      <a class="dropdown-item" href="{{ route('register') }}">Register</a>
    </div>
  @else
    {{-- <li class="nav-item dropdown"> --}}
    <a href="#" class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" role="button"
    aria-expanded="false" aria-haspopup="true">
    {{ Auth::user()->name }} <span class="caret"></span>
  </a>
  <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
    <li>
      <a style="color:#000;" href="{{ route('userOrders') }}"
      onclick="event.preventDefault();
      document.getElementById('userOrders-form').submit();">
      Orders
    </a>
    @include('includes.messages')
    <form id="userOrders-form" action="{{ route('userOrders')}}" method="GET" style="display:none;">
      {{ csrf_field() }}
    </form>
  </li>
  <li>
    <a style="color:#000;" href="{{ route('profile') }}"
    onclick="event.preventDefault();
    document.getElementById('profile-form').submit();">
    Profile
  </a>
  @include('includes.messages')
  <form id="profile-form" action="{{ route('profile')}}" method="GET" style="display:none;">
    {{ csrf_field() }}
  </form>
</li>
<hr>
<li>
  <a style="color:#000;" href="{{ route('logoutUser') }}"
  onclick="event.preventDefault();
  document.getElementById('logout-form').submit();">
  Logout
</a>
@include('includes.messages')
<form id="logout-form" action="{{ route('logoutUser') }}" method="GET" style="display:none;">
  {{ csrf_field() }}
</form>
</li>
</ul>
{{-- </li> --}}
@endguest
</li>
</ul>
</div>
<ul class="badge float-right bag">
  <li><a href="{{route('cart.index')}}">
    <i class="fa fa-shopping-bag fa-lg" aria-hidden="true"></i>
    <span style="color:#fff;background-color:#ff4646;">
      {{Cart::count()}}
    </span>
  </a></li>
</ul>
</nav>
