<?php
// Admin - Manage Produk
session_start();
include '../../config/Database.php';
include '../../config/functions.php';

$db = new Database();
$conn = $db->getConnection();

$message = '';
$edit_data = null;

// Handle Delete
if(isset($_GET['delete'])) {
    $id = $_GET['delete'];
    if(deleteProduct($conn, $id)) {
        $message = '<div class="alert alert-success">Produk berhasil dihapus!</div>';
    } else {
        $message = '<div class="alert alert-danger">Error menghapus produk!</div>';
    }
}

// Handle Add/Update
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_produk = $_POST['nama_produk'] ?? '';
    $id_kategori = $_POST['id_kategori'] ?? '';
    $harga = $_POST['harga'] ?? '';
    $stock = $_POST['stock'] ?? '';
    $deskripsi = $_POST['deskripsi'] ?? '';
    $gambar_produk = $_POST['gambar_produk'] ?? '';

    if(isset($_POST['id_produk']) && !empty($_POST['id_produk'])) {
        // Update
        if(updateProduct($conn, $_POST['id_produk'], $nama_produk, $id_kategori, $harga, $stock, $deskripsi, $gambar_produk)) {
            $message = '<div class="alert alert-success">Produk berhasil diupdate!</div>';
        } else {
            $message = '<div class="alert alert-danger">Error update produk!</div>';
        }
    } else {
        // Add
        if(addProduct($conn, $nama_produk, $id_kategori, $harga, $stock, $deskripsi, $gambar_produk)) {
            $message = '<div class="alert alert-success">Produk berhasil ditambahkan!</div>';
        } else {
            $message = '<div class="alert alert-danger">Error menambah produk!</div>';
        }
    }
}

// Get edit data
if(isset($_GET['edit'])) {
    $result = getProductById($conn, $_GET['edit']);
    $edit_data = mysqli_fetch_assoc($result);
}

// Get all products
$products = getAllProducts($conn);

// Get categories
$categories = getAllCategories($conn);

?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Manage Produk - Admin Dashboard</title>
  <link rel="stylesheet" href="./assets/css/styles.min.css" />
  <style>
    .form-section { background: #f9f9f9; padding: 20px; border-radius: 8px; margin-bottom: 20px; }
    table { font-size: 14px; }
    .action-btn { margin: 2px; padding: 5px 10px; font-size: 12px; }
  </style>
</head>

<body>
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">

    <!--  App Topstrip -->
    <div class="app-topstrip bg-dark py-2 px-3 w-100 d-lg-flex align-items-center justify-content-between">
      <h3 class="text-white mb-0 fs-6">🍰 Bakery Admin - Manage Produk</h3>
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

    <!-- Main wrapper -->
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
              <h1 class="page-title">Manage Produk</h1>
            </div>
          </div>

          <?php echo $message; ?>

          <!-- Form Tambah/Edit -->
          <div class="row mb-4">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h5 class="card-title mb-0"><?php echo $edit_data ? 'Edit Produk' : 'Tambah Produk Baru'; ?></h5>
                </div>
                <div class="card-body">
                  <form method="POST" action="">
                    <?php if($edit_data): ?>
                      <input type="hidden" name="id_produk" value="<?php echo $edit_data['id_produk']; ?>">
                    <?php endif; ?>

                    <div class="row">
                      <div class="col-md-6 mb-3">
                        <label class="form-label">Nama Produk *</label>
                        <input type="text" name="nama_produk" class="form-control" required
                          value="<?php echo $edit_data['nama_produk'] ?? ''; ?>">
                      </div>

                      <div class="col-md-6 mb-3">
                        <label class="form-label">Kategori *</label>
                        <select name="id_kategori" class="form-control" required>
                          <option value="">-- Pilih Kategori --</option>
                          <?php
                          while($cat = mysqli_fetch_assoc($categories)) {
                            $selected = ($edit_data && $edit_data['id_kategori'] == $cat['id_kategori']) ? 'selected' : '';
                            echo "<option value='" . $cat['id_kategori'] . "' $selected>" . $cat['nama_kategori'] . "</option>";
                          }
                          ?>
                        </select>
                      </div>

                      <div class="col-md-6 mb-3">
                        <label class="form-label">Harga (Rp) *</label>
                        <input type="number" name="harga" class="form-control" step="1000" required
                          value="<?php echo $edit_data['harga'] ?? ''; ?>">
                      </div>

                      <div class="col-md-6 mb-3">
                        <label class="form-label">Stock *</label>
                        <input type="number" name="stock" class="form-control" required
                          value="<?php echo $edit_data['stock'] ?? ''; ?>">
                      </div>

                      <div class="col-12 mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="3"><?php echo $edit_data['deskripsi'] ?? ''; ?></textarea>
                      </div>

                      <div class="col-12 mb-3">
                        <label class="form-label">Nama File Gambar</label>
                        <input type="text" name="gambar_produk" class="form-control" placeholder="Contoh: Rectangle 8.png"
                          value="<?php echo $edit_data['gambar_produk'] ?? ''; ?>">
                        <small class="text-muted">File gambar harus ada di folder /image/</small>
                      </div>

                      <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                          <?php echo $edit_data ? 'Update Produk' : 'Tambah Produk'; ?>
                        </button>
                        <?php if($edit_data): ?>
                          <a href="./manage-produk.php" class="btn btn-secondary">Batal</a>
                        <?php endif; ?>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>

          <!-- Daftar Produk -->
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h5 class="card-title mb-0">Daftar Produk (<?php echo mysqli_num_rows($products); ?> items)</h5>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Nama Produk</th>
                          <th>Kategori</th>
                          <th>Harga</th>
                          <th>Stock</th>
                          <th>Deskripsi</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        if($products && mysqli_num_rows($products) > 0) {
                          while($prod = mysqli_fetch_assoc($products)) {
                            echo "<tr>
                                    <td>" . $prod['id_produk'] . "</td>
                                    <td><strong>" . $prod['nama_produk'] . "</strong></td>
                                    <td><span class='badge bg-info'>" . $prod['nama_kategori'] . "</span></td>
                                    <td>" . formatIDR($prod['harga']) . "</td>
                                    <td>
                                      <span class='badge " . ($prod['stock'] > 20 ? 'bg-success' : ($prod['stock'] > 10 ? 'bg-warning' : 'bg-danger')) . "'>
                                        " . $prod['stock'] . "
                                      </span>
                                    </td>
                                    <td>" . substr($prod['deskripsi'], 0, 50) . "...</td>
                                    <td>
                                      <a href='?edit=" . $prod['id_produk'] . "' class='btn btn-sm btn-warning action-btn'>Edit</a>
                                      <a href='?delete=" . $prod['id_produk'] . "' class='btn btn-sm btn-danger action-btn' onclick=\"return confirm('Yakin hapus?')\">Hapus</a>
                                    </td>
                                  </tr>";
                          }
                        } else {
                          echo "<tr><td colspan='7' class='text-center text-muted'>Tidak ada produk</td></tr>";
                        }
                        ?>
                      </tbody>
                    </table>
                  </div>
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
