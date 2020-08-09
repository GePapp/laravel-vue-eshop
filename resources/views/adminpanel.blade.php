<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>SundanceAdmin Panel</title>

  <!-- STYLES app.css -->
  <link rel="stylesheet" href="/css/app.css">

</head>
<body class="hold-transition sidebar-mini">
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

      <div class="input-group input-group-sm col-4">
        <input class="form-control form-control-navbar" @keyup="searchIt" v-model="search" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" @click="searchIt">
            <i class="fa fa-search"></i>
          </button>
        </div>
      </div>

  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <div>
      <img src="img/adminPanel/sundancePanel.png" alt="AdminLTE Logo" style="opacity: .8">
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="img/adminPanel/profile.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ Auth::user()->name }}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
               <li class="nav-item">
                 <router-link to="/users" class="nav-link">
                   <i class="nav-icon fas fa-user text-green"></i>
                   <p>
                     Panel Users
                   </p>
                 </router-link>
               </li>

               <li class="nav-item">
                 <router-link to="/map" class="nav-link">
                   <i class="nav-icon fas fa-shopping-bag text-orange"></i>
                   <p>
                     Site Shop - Maps
                   </p>
                 </router-link>
               </li>

          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-shopping-cart text-blue"></i>
              <p>
                E-Shop Management
                <i class="right fa fa-angle-left text-blue"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">

              <li class="nav-item">
                <router-link to="/customers" class="nav-link">
                  <i class="nav-icon fas fa-user-friends text-cyan"></i>
                  <p>Customers</p>
                </router-link>
              </li>

              <li class="nav-item">
                <router-link to="/orders" class="nav-link">
                  <i class="nav-icon fas fa-shopping-basket text-cyan"></i>
                  <p>Orders</p>
                </router-link>
              </li>

              <li class="nav-item">
                <router-link to="/consultation" class="nav-link">
                  <i class="nav-icon fas fa-mobile text-cyan"></i>
                  <p>Consultations</p>
                </router-link>
              </li>

            </ul>
          </li>

          <li class="nav-item">
            <router-link to="/developer" class="nav-link">
              <i class="nav-icon fab fa-node-js text-indigo"></i>
              <p>
                Developer
              </p>
            </router-link>
          </li>

          <li class="nav-item">
            <router-link to="/mailer" class="nav-link">
              <i class="nav-icon fas fa-at"></i>
              <p>
                Mailer
              </p>
            </router-link>
          </li>

          <!-- Logout -->
          <li class="nav-item">
            <a class="nav-link" href="{{ route('logout') }}"
               onclick="event.preventDefault();
               document.getElementById('logout-form').submit();">
               <i class="nav-icon fa fa-power-off text-red"></i>
               <p>
                {{ __('Logout') }}
              </p>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
          </li>
          <!-- End Logout -->
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">

        <!-- Vue Output -->
        <router-view></router-view>

      </div>
      <!-- /.container-fluid -->
    </div>
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <footer class="main-footer no-print">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      <strong>© Copyright:</strong> Georg Stockhorst. All rights reserved.
    </div>
    <!-- Default to the left -->

  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- app.js -->
<script src="/js/app.js"></script>

</body>
</html>
