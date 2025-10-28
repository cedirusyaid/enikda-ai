
<?php $current_controller = $this->router->fetch_class(); 
$user_data = $this->session->userdata();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ENIKDA</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url('assets/adminlte/plugins/fontawesome-free/css/all.min.css'); ?>">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo base_url('assets/datatables/css/dataTables.bootstrap4.min.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css'); ?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url('assets/adminlte/dist/css/adminlte.min.css'); ?>">
  <style>
    /* Table Header Uniformity */
    .table thead th {
      background-color: #ffffff; /* Light background (white) */
      color: #000000; /* Dark text color (black) */
      text-align: center;
      vertical-align: middle;
    }
  </style>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-dark bg-purple">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <!-- <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li> -->
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
    <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <?php if (isset($user_data['is_logged_in']) && $user_data['is_logged_in'] == true): ?>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="far fa-user nav-icon"></i> <?php echo $user_data['nama']; ?>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="<?php echo base_url('user/profile'); ?>">
            <i class="far fa-id-card nav-icon"></i> Profile
          </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="<?php echo base_url('user/logout'); ?>">
            <i class="fas fa-sign-out-alt nav-icon"></i> Logout
          </a>
        </div>
      </li>
      <?php else: ?>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo base_url('user/login'); ?>">
            <i class="fas fa-sign-in-alt nav-icon"></i> Login
          </a>
        </li>
      <?php endif; ?>

    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-purple elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo site_url('dashboard'); ?>" class="brand-link">
      <img src="<?php echo base_url('assets/img/logo_sinjai.png'); ?>" alt="Logo Sinjai" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">ENIKDA</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <?php
            $controller = $this->router->fetch_class();
            $method = $this->router->fetch_method();
          ?>
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="<?php echo site_url('berkas/dashboard'); ?>" class="nav-link <?php echo ($controller == 'berkas' && $method == 'dashboard') ? 'active' : ''; ?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <?php 
            $master_controllers = ['unit', 'jabatan', 'pegawai'];
            $is_master_menu_open = in_array($controller, $master_controllers);
          ?>
          <li class="nav-item <?php echo $is_master_menu_open ? 'menu-open' : ''; ?>">
            <a href="#" class="nav-link <?php echo $is_master_menu_open ? 'active' : ''; ?>">
              <i class="nav-icon fas fa-database"></i>
              <p>
                Master Data
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo site_url('unit'); ?>" class="nav-link <?php echo ($controller == 'unit') ? 'active' : ''; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>OPD</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo site_url('jabatan'); ?>" class="nav-link <?php echo ($controller == 'jabatan') ? 'active' : ''; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Jabatan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo site_url('pegawai'); ?>" class="nav-link <?php echo ($controller == 'pegawai') ? 'active' : ''; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pegawai</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="<?php echo site_url('absensi'); ?>" class="nav-link <?php echo ($controller == 'absensi') ? 'active' : ''; ?>">
              <i class="nav-icon fas fa-clock"></i>
              <p>Absensi</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo site_url('kinerja'); ?>" class="nav-link <?php echo ($controller == 'kinerja') ? 'active' : ''; ?>">
              <i class="nav-icon fas fa-chart-line"></i>
              <p>Kinerja</p>
            </a>
          </li>

          <li class="nav-item <?php echo ($controller == 'ekin') ? 'menu-open' : ''; ?>">
            <a href="#" class="nav-link <?php echo ($controller == 'ekin') ? 'active' : ''; ?>">
              <i class="nav-icon fas fa-cogs"></i>
              <p>
                E-Kinerja
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo site_url('ekin/konfigurasi'); ?>" class="nav-link <?php echo ($method == 'konfigurasi') ? 'active' : ''; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Konfigurasi API</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo site_url('ekin/periode'); ?>" class="nav-link <?php echo ($method == 'periode') ? 'active' : ''; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Kelola Periode</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo site_url('ekin/sinkronisasi_penilaian_form'); ?>" class="nav-link <?php echo ($method == 'sinkronisasi_penilaian_form') ? 'active' : ''; ?>">
                  <i class="fas fa-sync-alt nav-icon"></i>
                  <p>Sinkronisasi Manual</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo site_url('ekin/penilaian_pegawai_list'); ?>" class="nav-link <?php echo ($method == 'penilaian_pegawai_list' || $method == 'lihat_penilaian') ? 'active' : ''; ?>">
                  <i class="fas fa-book nav-icon"></i>
                  <p>Laporan per Pegawai</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo site_url('ekin/laporan_per_unit'); ?>" class="nav-link <?php echo ($method == 'laporan_per_unit') ? 'active' : ''; ?>">
                  <i class="fas fa-chart-pie nav-icon"></i>
                  <p>Laporan per Unit</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo site_url('ekin/debug_periode_api'); ?>" class="nav-link" target="_blank">
                  <i class="fas fa-bug nav-icon"></i>
                  <p>Debug Periode API</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item <?php echo ($controller == 'berkas') ? 'menu-open' : ''; ?>">
            <a href="#" class="nav-link <?php echo ($controller == 'berkas') ? 'active' : ''; ?>">
              <i class="nav-icon fas fa-folder-open"></i>
              <p>
                Berkas TPP
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo site_url('berkas'); ?>" class="nav-link <?php echo ($method == 'index' || $method == 'detail') ? 'active' : ''; ?>">
                  <i class="fas fa-file-import nav-icon"></i>
                  <p>Pengajuan Berkas</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo site_url('berkas/create'); ?>" class="nav-link <?php echo ($method == 'create') ? 'active' : ''; ?>">
                  <i class="fas fa-upload nav-icon"></i>
                  <p>Unggah Berkas</p>
                </a>
              </li>
              <?php if($this->session->userdata('admin_kabupaten') == 1): ?>
              <li class="nav-item">
                <a href="<?php echo site_url('berkas/review'); ?>" class="nav-link <?php echo ($method == 'review' || $method == 'review_detail') ? 'active' : ''; ?>">
                  <i class="fas fa-tasks nav-icon"></i>
                  <p>Review Berkas</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo site_url('berkas/review_report'); ?>" class="nav-link <?php echo ($method == 'review_report') ? 'active' : ''; ?>">
                  <i class="fas fa-chart-bar nav-icon"></i>
                  <p>Laporan Review</p>
                </a>
              </li>
              <?php endif; ?>
            </ul>
          </li>

          <li class="nav-item <?php echo ($controller == 'Tpp') ? 'menu-open' : ''; ?>">
            <a href="#" class="nav-link <?php echo ($controller == 'Tpp') ? 'active' : ''; ?>">
              <i class="nav-icon fas fa-money-bill-wave"></i>
              <p>
                Perhitungan TPP
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Perhitungan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Penilaian</p>
                </a>
              </li>
            </ul>
          </li>
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
