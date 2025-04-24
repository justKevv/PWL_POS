<div class="sidebar">
    <!-- Sidebar user (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex flex-column align-items-center"> {{-- Modified for centering --}}
        <div class="image mb-2"> {{-- Added margin bottom --}}
            {{-- Display user image or default --}}
            <img src="{{ Auth::user()->profile_image ? Storage::url(Auth::user()->profile_image) : asset('adminlte/dist/img/user2-160x160.jpg') }}"
                 class="img-circle elevation-2" alt="User Image" style="width: 60px; height: 60px; object-fit: cover;"> {{-- Added style --}}
        </div>
        <div class="info mb-2 text-center"> {{-- Added margin bottom and text center --}}
            {{-- Display user name --}}
            <a href="#" class="d-block">{{ Auth::user()->name }}</a>
        </div>
        {{-- Simple Form for Profile Photo Upload --}}
        <form action="{{ route('profile.photo.update') }}" method="POST" enctype="multipart/form-data" class="w-100 px-2"> {{-- Added width and padding --}}
            @csrf
            <div class="input-group input-group-sm">
                <input type="file" name="profile_photo" class="form-control form-control-sm" required>
                <div class="input-group-append">
                    <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-upload"></i></button>
                </div>
            </div>
             @error('profile_photo') {{-- Display validation error --}}
                <small class="text-danger d-block mt-1">{{ $message }}</small>
            @enderror
            @if (session('success')) {{-- Display success message --}}
                 <small class="text-success d-block mt-1">{{ session('success') }}</small>
            @endif
             @if (session('error')) {{-- Display error message --}}
                 <small class="text-danger d-block mt-1">{{ session('error') }}</small>
            @endif
        </form>
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

    <!-- Logout button -->
    <div class="mt-auto" style="position: absolute; bottom: 0; width: 100%; padding: 1rem;">
      <ul class="nav nav-pills nav-sidebar flex-column">
        <li class="nav-item">
          <a href="{{ url('/logout') }}" class="nav-link">
            <i class="nav-icon fas fa-sign-out-alt"></i>
            <p>Logout</p>
          </a>
        </li>
      </ul>
    </div>
  </div>
