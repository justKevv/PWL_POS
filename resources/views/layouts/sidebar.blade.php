<div class="sidebar">
    <!-- Sidebar user (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="{{ asset('adminlte/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block">Alexander Pierce</a>
      </div>
    </div>

    <!-- SidebarSearch Form -->
    <div class="form-inline">
      <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-sidebar">
            <i class="fas fa-search fa-fw"></i>
          </button>
        </div>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        <li class="nav-item">
          <a href="{{ url('/') }}" class="nav-link {{ ($activeMenu == 'dashboard') ? 'active' : '' }}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>
        <li class="nav-header">User Data</li>
        <li class="nav-item">
          <a href="{{ url('/level') }}" class="nav-link {{ ($activeMenu == 'level') ? 'active' : '' }}">
            <i class="nav-icon fas fa-layer-group"></i>
            <p>User Level</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ url('/user') }}" class="nav-link {{ ($activeMenu == 'user') ? 'active' : '' }}">
            <i class="nav-icon far fa-user"></i>
            <p>
              User Data
            </p>
          </a>
        </li>
        <li class="nav-header">Item Data</li>
        <li class="nav-item">
          <a href="{{ url('/category') }}" class="nav-link {{ ($activeMenu == 'category') ? 'active' : '' }}">
            <i class="nav-icon far fa-bookmark"></i>
            <p>Goods Category</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ url('/item') }}" class="nav-link {{ ($activeMenu == 'item') ? 'active' : '' }}">
            <i class="nav-icon far fa-list-alt"></i>
            <p>Goods Data</p>
          </a>
        </li>
        <li class="nav-header">Transaction Data</li>
        <li class="nav-item">
          <a href="{{ url('/stock') }}" class="nav-link {{ ($activeMenu == 'stock') ? 'active' : '' }}">
            <i class="nav-icon fas fa-cubes"></i>
            <p>Stocks of Goods</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ url('/sales') }}" class="nav-link {{ ($activeMenu == 'sales') ? 'active' : '' }}">
            <i class="nav-icon fas fa-cash-register"></i>
            <p>
              Sales Transaction
            </p>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
