<?php
// Admin Dashboard - Terintegrasi dengan Database
session_start();
include '../../config/Database.php';
include '../../config/functions.php';
include '../../config/session.php';

// Jika belum login, redirect ke login
// requireLogin(); // Uncomment jika ingin force login

$db = new Database();
$conn = $db->getConnection();

// Get statistics
$total_produk = mysqli_num_rows(getAllProducts($conn));
$total_kategori = mysqli_num_rows(getAllCategories($conn));
$total_users = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tb_users"));

// Get recent products
$recent_products = mysqli_query($conn, "SELECT p.*, k.nama_kategori FROM tb_produk p 
                                        LEFT JOIN tb_kategori k ON p.id_kategori = k.id_kategori 
                                        ORDER BY p.id_produk DESC LIMIT 5");

// Get all categories for sidebar
$categories = getAllCategories($conn);

?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Dashboard - Bakery System</title>
  <link rel="stylesheet" href="./assets/css/styles.min.css" />
  <style>
    .stat-card {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      padding: 20px;
      border-radius: 8px;
      text-align: center;
      margin-bottom: 20px;
    }
    .stat-card h4 {
      margin: 10px 0 5px;
      font-size: 24px;
      font-weight: bold;
    }
    .stat-card p {
      margin: 0;
      font-size: 12px;
      opacity: 0.9;
    }
    .stat-card.blue { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
    .stat-card.green { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
    .stat-card.orange { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }
    
    table { font-size: 14px; }
    .badge { padding: 5px 10px; border-radius: 20px; }
    .action-btn { margin: 2px; padding: 5px 10px; font-size: 12px; }
  </style>
</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">

    <!--  App Topstrip -->
    <div class="app-topstrip bg-dark py-2 px-3 w-100 d-lg-flex align-items-center justify-content-between">
      <div class="d-flex align-items-center justify-content-center gap-3 mb-2 mb-lg-0">
        <h3 class="text-white mb-0 fs-6">🍰 Bakery Admin Dashboard</h3>
      </div>

      <div class="d-lg-flex align-items-center gap-2">
        <div class="dropdown">
          <a class="btn btn-sm btn-primary d-flex align-items-center gap-1" href="javascript:void(0)" id="drop4"
            data-bs-toggle="dropdown" aria-expanded="false">
            <i class="ti ti-user fs-5"></i>
            Admin
            <i class="ti ti-chevron-down fs-5"></i>
          </a>
          <ul class="dropdown-menu" aria-labelledby="drop4">
            <li><a class="dropdown-item" href="javascript:void(0)">Profile</a></li>
            <li><a class="dropdown-item" href="../../login.php?logout=1">Logout</a></li>
          </ul>
        </div>
      </div>
    </div>

    <!-- Sidebar Start -->
    <aside class="left-sidebar">
      <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
          <a href="./dashboard.php" class="text-nowrap logo-img">
            <img src="./assets/images/logos/logo.svg" alt="" /> Bakery
          </a>
          <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
            <i class="ti ti-x fs-6"></i>
          </div>
        </div>

        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
          <ul id="sidebarnav">
            <li class="nav-small-cap">
              <span class="hide-menu">MENU UTAMA</span>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="./dashboard.php" aria-expanded="false">
                <i class="ti ti-home"></i>
                <span class="hide-menu">Dashboard</span>
              </a>
            </li>

            <li class="nav-small-cap">
              <span class="hide-menu">MANAJEMEN</span>
            </li>

            <li class="sidebar-item">
              <a class="sidebar-link" href="./manage-produk.php" aria-expanded="false">
                <i class="ti ti-package"></i>
                <span class="hide-menu">Produk</span>
              </a>
            </li>

            <li class="sidebar-item">
              <a class="sidebar-link" href="./manage-kategori.php" aria-expanded="false">
                <i class="ti ti-tags"></i>
                <span class="hide-menu">Kategori</span>
              </a>
            </li>

            <li class="sidebar-item">
              <a class="sidebar-link" href="./manage-users.php" aria-expanded="false">
                <i class="ti ti-users"></i>
                <span class="hide-menu">Users</span>
              </a>
            </li>

            <li>
              <span class="sidebar-divider lg"></span>
            </li>

            <li class="nav-small-cap">
              <span class="hide-menu">AKUN</span>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="../../login.php?logout=1" aria-expanded="false">
                <i class="ti ti-logout"></i>
                <span class="hide-menu">Logout</span>
              </a>
            </li>
          </ul>
        </nav>
      </div>
    </aside>

    <!-- Main wrapper -->
    <div class="body-wrapper">
      <!-- Header -->
      <header class="app-header">
        <nav class="navbar navbar-expand-lg navbar-light">
          <ul class="navbar-nav">
            <li class="nav-item d-block d-xl-none">
              <a class="nav-link sidebartoggler" id="headerCollapse" href="javascript:void(0)">
                <i class="ti ti-menu-2"></i>
              </a>
            </li>
          </ul>
        </nav>
      </header>

      <!-- Main content -->
      <main class="main-content">
        <div class="container-fluid">
          <!-- Page Title -->
          <div class="row mb-4">
            <div class="col-12">
              <h1 class="page-title">Dashboard</h1>
              <p class="text-muted">Selamat datang di admin panel bakery system</p>
            </div>
          </div>

          <!-- Statistics Cards -->
          <div class="row">
            <div class="col-md-4">
              <div class="stat-card blue">
                <i class="ti ti-package" style="font-size: 30px;"></i>
                <h4><?php echo $total_produk; ?></h4>
                <p>Total Produk</p>
              </div>
            </div>
            <div class="col-md-4">
              <div class="stat-card green">
                <i class="ti ti-tags" style="font-size: 30px;"></i>
                <h4><?php echo $total_kategori; ?></h4>
                <p>Total Kategori</p>
              </div>
            </div>
            <div class="col-md-4">
              <div class="stat-card orange">
                <i class="ti ti-users" style="font-size: 30px;"></i>
                <h4><?php echo $total_users; ?></h4>
                <p>Total Users</p>
              </div>
            </div>
          </div>

          <!-- Recent Products -->
          <div class="row mt-4">
            <div class="col-12">
              <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                  <h5 class="card-title mb-0">Produk Terbaru</h5>
                  <a href="./manage-produk.php" class="btn btn-sm btn-primary">Lihat Semua</a>
                </div>
                <div class="card-body">
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stock</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      if($recent_products && mysqli_num_rows($recent_products) > 0) {
                        while($prod = mysqli_fetch_assoc($recent_products)) {
                          echo "<tr>
                                  <td>" . $prod['id_produk'] . "</td>
                                  <td>" . $prod['nama_produk'] . "</td>
                                  <td><span class='badge bg-info'>" . $prod['nama_kategori'] . "</span></td>
                                  <td><strong>" . formatIDR($prod['harga']) . "</strong></td>
                                  <td>
                                    <span class='badge " . ($prod['stock'] > 20 ? 'bg-success' : ($prod['stock'] > 10 ? 'bg-warning' : 'bg-danger')) . "'>
                                      " . $prod['stock'] . "
                                    </span>
                                  </td>
                                  <td>
                                    <a href='./manage-produk.php?edit=" . $prod['id_produk'] . "' class='btn btn-sm btn-warning action-btn'>Edit</a>
                                    <a href='./manage-produk.php?delete=" . $prod['id_produk'] . "' class='btn btn-sm btn-danger action-btn' onclick=\"return confirm('Yakin hapus?')\">Hapus</a>
                                  </td>
                                </tr>";
                        }
                      } else {
                        echo "<tr><td colspan='6' class='text-center text-muted'>Tidak ada produk</td></tr>";
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

          <!-- Quick Actions -->
          <div class="row mt-4">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h5 class="card-title mb-0">Aksi Cepat</h5>
                </div>
                <div class="card-body">
                  <div class="d-flex gap-2 flex-wrap">
                    <a href="./manage-produk.php?action=add" class="btn btn-primary">
                      <i class="ti ti-plus"></i> Tambah Produk
                    </a>
                    <a href="./manage-kategori.php" class="btn btn-info">
                      <i class="ti ti-plus"></i> Tambah Kategori
                    </a>
                    <a href="./manage-users.php" class="btn btn-success">
                      <i class="ti ti-users"></i> Lihat Users
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
      </main>

    </div>
  </div>

  <!-- Scripts -->
  <script src="./assets/js/app.min.js"></script>
  <script src="./assets/js/dashboard.js"></script>
</body>

</html>
