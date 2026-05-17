<?php
$page_css = "shopall.css";
include 'komponen/header.php';

include 'config/Database.php';

$database = new Database();
$conn = $database->getConnection();

$query = mysqli_query($conn, "SELECT p.*, k.nama_kategori FROM tb_produk p 
                             LEFT JOIN tb_kategori k ON p.id_kategori = k.id_kategori 
                             ORDER BY p.id_produk");
?>

 <section class="scroll">
    <div class="scroll-images">
      <img src="image/Rectangle 21.png" alt="cake1">
      <img src="image/Rectangle 22.png" alt="cake2">
      <img src="image/Rectangle 23.png" alt="cake3">
      <img src="image/Rectangle 24.png" alt="cake4">
      <!-- ulangi -->
      <img src="image/Rectangle 21.png" alt="cake1">
      <img src="image/Rectangle 22.png" alt="cake2">
      <img src="image/Rectangle 23.png" alt="cake3">
      <img src="image/Rectangle 24.png" alt="cake4">
      <!-- ulangi -->
      <img src="image/Rectangle 21.png" alt="cake1">
      <img src="image/Rectangle 22.png" alt="cake2">
      <img src="image/Rectangle 23.png" alt="cake3">
      <img src="image/Rectangle 24.png" alt="cake4">
      <!-- ulangi -->
      <img src="image/Rectangle 21.png" alt="cake1">
      <img src="image/Rectangle 22.png" alt="cake2">
      <img src="image/Rectangle 23.png" alt="cake3">
      <img src="image/Rectangle 24.png" alt="cake4">
    </div>
    <div class="scroll-text">DELI BAKERY CAKE</div>
  </section>

  <!-- MENU SECTION -->
  <section class="menu">
    <div class="menu-icon">🍰</div>
    <h2>Our Regular Menu</h2>
    <p>
      Even though this is our regular menu, we use premium ingredients 
      and affordable prices.
    </p>
  </section>

 <!-- wrapper coklat -->
  <div class="menu-wrapper">
    <section class="menu-section">
      <div class="menu-grid">

<?php 
if($query && mysqli_num_rows($query) > 0) {
    while($row = mysqli_fetch_assoc($query)) { 
?>

    <div class="menu-item">
        <img src="image/<?php echo $row['gambar_produk']; ?>" alt="<?php echo $row['nama_produk']; ?>">

        <div class="menu-info">
            <h3><?php echo $row['nama_produk']; ?></h3>
            <p class="kategori" style="font-size: 12px; color: #999;">Kategori: <?php echo $row['nama_kategori']; ?></p>
            <p><?php echo $row['deskripsi']; ?></p>

            <a href="#" class="price-btn">
                🛒 Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?>
            </a>
        </div>
    </div>

<?php 
    }
} else {
    echo "<p>Tidak ada produk yang tersedia. Silahkan tambahkan produk terlebih dahulu.</p>";
}
?>

      </div>
    </section>
  </div>

    <!-- MENU SECTION -->
  <section class="menu">
    <div class="menu-icon">🍰</div>
    <h2>Our  event cake Menu </h2>
    <p>
     Our special menu is seasonal cakes. We only make these cakes during certain seasons, such as during orange and lemon season, we make several special cakes.
    </p>
  </section>

 <!-- wrapper maroon -->
  <div class="menu-wrapper2">
    <section class="menu-section2">
      <div class="menu-grid2">
        <!-- Item 1 -->
        <div class="menu-item1b">
          <img src="../image/Rectangle 8.png" alt="oriangest cake">
          <div class="menu-info">
            <h3>oriangest Cake</h3>
            <p>Made with premium ingredients and carefully processed, each bite is delicious and feels like heaven.</p>
            <a href="#" class="price-btn2"><span>🛒</span>IDR 17.000</a>
          </div>
        </div>

        <!-- Item 2 -->
        <div class="menu-item1b">
          <img src="../image/Rectangle 21.png" alt="Double Sweet donut">
          <div class="menu-info2">
            <h3>Double Sweet donut</h3>
            <p>Made with premium ingredients and carefully processed, each bite is delicious and feels like heaven.</p>
            <a href="#" class="price-btn2"><span>🛒</span>IDR 25.000</a>
          </div>
        </div>

        <!-- Item 3 -->
        <div class="menu-item1b">
          <img src="../image/Rectangle 29.png" alt="Brownies Bites">
          <div class="menu-info2">
            <h3>Brownies Bites</h3>
            <p>Made with premium ingredients and carefully processed, each bite is delicious and feels like heaven.</p>
            <a href="#" class="price-btn2"><span>🛒</span>IDR 20.000</a>
          </div>
        </div>

        <!-- Item 4 -->
        <div class="menu-item1b">
          <img src="../image/Rectangle 19.png" alt="Elmo Chocokiss">
          <div class="menu-info2">
            <h3>Elmo Chocokiss</h3>
            <p>Made with premium ingredients and carefully processed, each bite is delicious and feels like heaven.</p>
            <a href="#" class="price-btn2"><span>🛒</span>IDR 23.000</a>
          </div>
        </div>

        <!-- Item 5 -->
        <div class="menu-item2b">
          <img src="../image/Rectangle 35.png" alt="Cromboloni choco layer">
          <div class="menu-info2">
            <h3>Cromboloni choco layer</h3>
            <p>Made with premium ingredients and carefully processed, each bite is delicious and feels like heaven.</p>
            <a href="#" class="price-btn2"><span>🛒</span>IDR 25.000</a>
          </div>
        </div>

        <!-- Item 6 -->
        <div class="menu-item2b">
          <img src="../image/Rectangle 34.png" alt="Dessert Box Ifood">
          <div class="menu-info2">
            <h3>Dessert Box Ifood</h3>
            <p>Made with premium ingredients and carefully processed, each bite is delicious and feels like heaven.</p>
            <a href="#" class="price-btn2"><span>🛒</span>IDR 15.000</a>
          </div>
        </div>

        <!-- Item 7 -->
        <div class="menu-item2b">
          <img src="../image/Rectangle 18.png" alt="BerryPast">
          <div class="menu-info2">
            <h3>BerryPast</h3>
            <p>Made with premium ingredients and carefully processed, each bite is delicious and feels like heaven.</p>
            <a href="#" class="price-btn2"><span>🛒</span>IDR 20.000</a>
          </div>
        </div>

        <!-- Item 8 -->
        <div class="menu-item2b">
          <img src="../image/Rectangle 17.png" alt="Tiramissyou">
          <div class="menu-info2">
            <h3>Tiramissyou</h3>
            <p>Made with premium ingredients and carefully processed, each bite is delicious and feels like heaven.</p>
            <a href="#" class="price-btn2"><span>🛒</span>IDR 18.000</a>
          </div>
        </div>
      </div>
    </section>
  </div>

<section class="menu">
    <div class="menu-icon"></div>
  </section>

  <?php include 'komponen/footer.php'; ?>