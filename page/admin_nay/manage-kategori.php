<?php
// Admin - Manage Kategori
session_start();
include '../../config/Database.php';
include '../../config/functions.php';

$db = new Database();
$conn = $db->getConnection();

$message = '';

// Handle Delete
if(isset($_GET['delete'])) {
    $id = $_GET['delete'];
    if(mysqli_query($conn, "DELETE FROM tb_kategori WHERE id_kategori = '$id'")) {
        $message = '<div class="alert alert-success">Kategori berhasil dihapus!</div>';
    } else {
        $message = '<div class="alert alert-danger">Error menghapus kategori!</div>';
    }
}

// Handle Add/Update
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_kategori = mysqli_real_escape_string($conn, $_POST['nama_kategori']);

    if(isset($_POST['id_kategori']) && !empty($_POST['id_kategori'])) {
        // Update
        $id = $_POST['id_kategori'];
        if(mysqli_query($conn, "UPDATE tb_kategori SET nama_kategori='$nama_kategori' WHERE id_kategori='$id'")) {
            $message = '<div class="alert alert-success">Kategori berhasil diupdate!</div>';
        } else {
            $message = '<div class="alert alert-danger">Error update kategori!</div>';
        }
    } else {
        // Add
        if(mysqli_query($conn, "INSERT INTO tb_kategori (nama_kategori) VALUES ('$nama_kategori')")) {
            $message = '<div class="alert alert-success">Kategori berhasil ditambahkan!</div>';
        } else {
            $message = '<div class="alert alert-danger">Error menambah kategori!</div>';
        }
    }
}

$categories = getAllCategories($conn);

?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Manage Kategori - Admin Dashboard</title>
  <link rel="stylesheet" href="./assets/css/styles.min.css" />
</head>

<body>
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">

    <div class="app-topstrip bg-dark py-2 px-3 w-100 d-lg-flex align-items-center justify-content-between">
      <h3 class="text-white mb-0 fs-6">🍰 Bakery Admin - Manage Kategori</h3>
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
              <h1 class="page-title">Manage Kategori</h1>
            </div>
          </div>

          <?php echo $message; ?>

          <div class="row mb-4">
            <div class="col-md-6">
              <div class="card">
                <div class="card-header">
                  <h5 class="card-title mb-0">Tambah Kategori Baru</h5>
                </div>
                <div class="card-body">
                  <form method="POST" action="">
                    <div class="mb-3">
                      <label class="form-label">Nama Kategori *</label>
                      <input type="text" name="nama_kategori" class="form-control" required placeholder="Contoh: Kue Kering">
                    </div>
                    <button type="submit" class="btn btn-primary">Tambah Kategori</button>
                  </form>
                </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="card">
                <div class="card-header">
                  <h5 class="card-title mb-0">Daftar Kategori (<?php echo mysqli_num_rows($categories); ?>)</h5>
                </div>
                <div class="card-body">
                  <table class="table table-sm">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      while($cat = mysqli_fetch_assoc($categories)) {
                        echo "<tr>
                                <td>" . $cat['id_kategori'] . "</td>
                                <td>" . $cat['nama_kategori'] . "</td>
                                <td>
                                  <a href='?delete=" . $cat['id_kategori'] . "' class='btn btn-sm btn-danger' onclick=\"return confirm('Yakin?')\">Hapus</a>
                                </td>
                              </tr>";
                      }
                      ?>
                    </tbody>
                  </table>
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
