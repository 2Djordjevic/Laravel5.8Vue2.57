<html lang="en" style="height: auto;">
  <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta http-equiv="x-ua-compatible" content="ie=edge">
      <!-- CSRF Token -->
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <title>{{ config('app.name') }}</title>
      <link rel="stylesheet" href="/css/app.css">
  </head>
  <body class="sidebar-mini" style="height: auto;" >
    <div class="wrapper" id="app">
      <!-- Navbar -->
      <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">

        <!-- Left navbar links -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
          </li>
        </ul>

        <!-- SEARCH FORM -->
        <form class="form-inline ml-3">
          <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar" type="search" @keyup="searchHit" v-model="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
              <button class="btn btn-navbar" @click="searchHit">
                <i class="fa fa-search"></i>
              </button>
            </div>
          </div>
        </form>
      </nav>
      <!-- /.navbar -->

      <!-- Main Sidebar Container -->
      <aside class="main-sidebar sidebar-dark-primary elevation-4" style="min-height: 863px;">
        <!-- Brand Logo -->
        <a href="index3.html" class="brand-link">
          <img src="/img/logo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
          <span class="brand-text font-weight-light">Laravel and VueJs</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
          <!-- Sidebar user panel (optional) -->
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
              <img src="/img/profile.png" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">
                    {{ Auth::user()->name }} 
                    <p>Role: {{ ucfirst(Auth::user()->type) }} </p>
                </a>
            </div>
          </div>

          <!-- Sidebar Menu -->
          <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                  with font-awesome or any other icon font library -->

                <li class="nav-item">
                  <router-link to="/dashboard" class="nav-link"><i class="nav-icon fas fa-tachometer-alt"></i><p>Dashboad</p></router-link>
                </li>

                @can('isAdmin')
                <li class="nav-item has-treeview menu-close">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>
                            Management
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <router-link to="/users" class="nav-link">
                                <i class="nav-icon fas fa-users"></i>
                                <p>Users</p>
                            </router-link>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                  <router-link to="/developer" class="nav-link"><i class="nav-icon fas fa-cogs"></i><p>Developer</p></router-link>
                </li>
                @endCan

                <li class="nav-item">
                  <router-link to="/profile"  class="nav-link"><i class="nav-icon fas fa-user"></i><p>Profile</p></router-link>
                </li>

                <li class="nav-item">
                  <router-link to="/invoice"  class="nav-link"><i class="nav-icon fas fa-user"></i><p>Invoice</p></router-link>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}"
                      onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                      <i class="nav-icon fas fa-power-off"></i>
                      <p>{{ __('Logout') }}</p>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
          </nav>
          <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
      </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper" style="min-height: 863px;">
        <!-- Main content -->
        <div class="content">
          <div class="container-fluid">
            <router-view></router-view>
            <vue-progress-bar></vue-progress-bar>
          </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->

      <!-- Main Footer -->
      <footer class="main-footer">
        <!-- To the right -->
        <div class="float-right d-none d-sm-inline">
            Anything you want
        </div>
        <!-- Default to the left -->
        <strong> <a href="https://github.com/daranyK" target="_blank">Darany Khiev's Github</a>.</strong> 
      </footer>
    </div>
    <!-- ./wrapper -->

    @auth
      <script>
        window.user = @json(auth()->user());
      </script>
    @endauth
    <script src="/js/app.js"></script>
  </body>
</html>
