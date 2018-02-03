<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    {{-- <div class="user-panel">
      <div class="pull-left image">
        <img src="{{ asset('admin/dist/img/user2-160x160.jpg')}}" alt="\" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p>{{ Auth::user()->name }}</p>
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div> --}}
    <br>
    <ul class="sidebar-menu" data-widget="tree">
      {{-- <li class="header">MAIN NAVIGATION</li> --}}
      <li class="treeview">
        <a href="#"> <span>Products</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{ route('products.create')}}"><i class="fa fa-circle-o"></i>Add Products</a></li>
          <li><a href="{{ route('products.index')}}"><i class="fa fa-circle-o"></i> Show Products</a></li>
        </ul>
      </li>
      <li class="treeview">
        <a href="#">

          <span>Category</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{ route('category.create')}}"><i class="fa fa-circle-o"></i>Add Category</a></li>
          <li><a href="{{ route('category.index')}}"><i class="fa fa-circle-o"></i> Show Category</a></li>
        </ul>
      </li>
      <li class="treeview">
        <a href="#">

          <span>Size</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{ route('size.create')}}"><i class="fa fa-circle-o"></i>Add Size</a></li>
          <li><a href="{{ route('size.index')}}"><i class="fa fa-circle-o"></i> Show Size</a></li>
        </ul>
      </li>
      <li class="treeview">
        <a href="#">

          <span>Orders</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{url('admin/orders/pending')}}"><i class="fa fa-circle-o"></i>Pending Orders</a></li>
          <li><a href="{{url('admin/orders/delivered')}}"><i class="fa fa-circle-o"></i>Delivered Orders</a></li>
          <li><a href="{{url('admin/orders')}}"><i class="fa fa-circle-o"></i>All Orders</a></li>
        </ul>
      </li>
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>
