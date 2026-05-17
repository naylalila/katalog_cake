<?php
// Admin - Manage Users
session_start();
include '../../config/Database.php';
include '../../config/functions.php';

$db = new Database();
$conn = $db->getConnection();

$message = '';

// Handle Delete
if(isset($_GET['delete'])) {
    $id = $_GET['delete'];
    if(mysqli_query($conn, "DELETE FROM tb_users WHERE id_user = '$id'")) {
        $message = '<div class="alert alert-success">User berhasil dihapus!</div>';
    } else {
        $message = '<div class="alert alert-danger">Error menghapus user!</div>';
    }
}

// Get all users
$users = mysqli_query($conn, "SELECT * FROM tb_users ORDER BY id_user DESC");

?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Manage Users - Admin Dashboard</title>
  <link rel="stylesheet" href="./assets/css/styles.min.css" />
  <style>
    table { font-size: 14px; }
    .action-btn { margin: 2px; padding: 5px 10px; font-size: 12px; }
  </style>
</head>

<body>
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">

    <div class="app-topstrip bg-dark py-2 px-3 w-100 d-lg-flex align-items-center justify-content-between">
      <h3 class="text-white mb-0 fs-6">🍰 Bakery Admin - Manage Users</h3>
    </div>

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

        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
          <ul id="sidebarnav">
            <li class="nav-small-cap"><span class="hide-menu">MENU UTAMA</span></li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="./dashboard.php">
                <i class="ti ti-home"></i>
                <span class="hide-menu">Dashboard</span>
              </a>
            </li>

            <li class="nav-small-cap"><span class="hide-menu">MANAJEMEN</span></li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="./manage-produk.php">
                <i class="ti ti-package"></i>
                <span class="hide-menu">Produk</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="./manage-kategori.php">
                <i class="ti ti-tags"></i>
                <span class="hide-menu">Kategori</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="./manage-users.php">
                <i class="ti ti-users"></i>
                <span class="hide-menu">Users</span>
              </a>
            </li>
          </ul>
        </nav>
      </div>
    </aside>

    <div class="body-wrapper">
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

      <main class="main-content">
        <div class="container-fluid">
          <div class="row mb-4">
            <div class="col-12">
              <h1 class="page-title">Manage Users</h1>
              <p class="text-muted">Kelola akun user yang terdaftar di sistem</p>
            </div>
          </div>

          <?php echo $message; ?>

          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                  <h5 class="card-title mb-0">Daftar Users (<?php echo mysqli_num_rows($users); ?> users)</h5>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Nama</th>
                          <th>Email</th>
                          <th>No HP</th>
                          <th>Alamat</th>
                          <th>Terdaftar</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        if($users && mysqli_num_rows($users) > 0) {
                          while($user = mysqli_fetch_assoc($users)) {
                            echo "<tr>
                                    <td><strong>" . $user['id_user'] . "</strong></td>
                                    <td>" . $user['nama'] . "</td>
                                    <td>" . $user['email'] . "</td>
                                    <td>" . ($user['nomer_hp'] ?? '-') . "</td>
                                    <td>" . (substr($user['alamat'] ?? '-', 0, 30)) . "...</td>
                                    <td>" . date('d/m/Y H:i', strtotime($user['created_at'])) . "</td>
                                    <td>
                                      <a href='?delete=" . $user['id_user'] . "' class='btn btn-sm btn-danger action-btn' onclick=\"return confirm('Yakin hapus user ini?')\">Hapus</a>
                                    </td>
                                  </tr>";
                          }
                        } else {
                          echo "<tr><td colspan='7' class='text-center text-muted'>Tidak ada user terdaftar</td></tr>";
                        }
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>

              <!-- Info Box -->
              <div class="card mt-4">
                <div class="card-header">
                  <h5 class="card-title mb-0">Informasi</h5>
                </div>
                <div class="card-body">
                  <p><strong>Cara User Mendaftar:</strong></p>
                  <ol>
                    <li>User mengunjungi halaman login: <code>login.php?register=1</code></li>
                    <li>Isi form registrasi (Nama, Email, Password)</li>
                    <li>Password otomatis di-hash untuk keamanan</li>
                    <li>Data user tersimpan di tabel <code>tb_users</code></li>
                  </ol>

                  <p class="mt-3"><strong>Tips:</strong></p>
                  <ul>
                    <li>Setiap user email harus unik</li>
                    <li>Password di-hash menggunakan password_hash() PHP</li>
                    <li>Data user bisa dilihat dan dihapus dari sini</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>

        </div>
      </main>

    </div>
  </div>

  <script src="./assets/js/app.min.js"></script>
</body>

</html>
