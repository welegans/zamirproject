<header class="main-header">

  <!-- Logo -->
  <a href="{{ route('admin.home')}}" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"><b>FNF</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Admin </b>Panel</span>
    </a>
    <nav class="navbar navbar-static-top">
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <span class="hidden-xs">{{ Auth::user()->name }}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              {{-- <li class="user-header">
              <img src="{{ asset('admin/dist/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image">
              <p>{{ Auth::user()->name }}</p>
            </li> --}}
            <li class="">
              {{-- <div class="pull-left">
              <a href="#" class="btn btn-default btn-flat">Profile</a>
            </div> --}}
            <div class="pull-right">
              <a href="{{ route('logout') }}"
              onclick="event.preventDefault();
              document.getElementById('logout-form').submit();">
              Logout
            </a>
            @include('includes.messages')
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
              {{ csrf_field() }}
            </form>
            {{-- <a href="#" class="btn btn-default btn-flat">Sign out</a> --}}
          </div>
        </li>
      </ul>
    </li>
    <!-- Control Sidebar Toggle Button -->
    {{-- <li>
    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
  </li> --}}
</ul>
</div>
</nav>
</header>
