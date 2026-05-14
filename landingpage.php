<?php
$page_css = "style.css";
include 'komponen/header.php';
?>

 <section class="image1">
    <img src="../image/Rectangle 1 (1).png" alt="">
    <div class="hero-text">
      <h1>Freshly Baked, Just For You!</h1>
      <div class="line"></div>
      <p>open daily at 06.00 - 22.00 WIB on Jl. A.Yani no 68 Banyuwangi</p>
    </div>
  </section>

  <section class="favorites">
    <h2>Choose your favorite</h2>
    <p>Indulge yourself with our premium bread and pastries.</p>
    <div class="menu-grid">
      <?php
      // Data menu dalam array agar mudah ditambah/kurang nantinya
      $bakery_items = [
          ['img' => 'Rectangle 8.png', 'name' => 'Croissant sugar plum'],
          ['img' => 'Rectangle 9.png', 'name' => 'Waffle berry runch'],
          ['img' => 'Rectangle 13.png', 'name' => 'Burntcheese wolp berry'],
          ['img' => 'Rectangle 17.png', 'name' => 'Tiramissyou'],
          ['img' => 'Rectangle 18.png', 'name' => 'BerryPast'],
          ['img' => 'Rectangle 19.png', 'name' => 'Elmo Chocokiss'],
      ];

      foreach ($bakery_items as $item) { ?>
          <div class="menu-item">
            <img src="../image/<?php echo $item['img']; ?>" alt="<?php echo $item['name']; ?>" />
            <h3><?php echo $item['name']; ?></h3>
            <p>Made with premium ingredients and carefully processed, each bite is delicious and feels like heaven.</p>
          </div>
      <?php } ?>
    </div>
    <a href="shopall.php" class="view-all">View all </a>
  </section>

<section class="gallery"> 
  <h2>🍰 Gallery</h2>
  <div class="gallery-images">
    <div class="image-container">
      <img src="../image/Rectangle 65 (1).png" alt="">
      <div class="overlay-text"><span class="highlight">WE ARE</span> OPEN!</div>
    </div>
    <div class="image-container">
      <img src="../image/Rectangle 67.png" alt="">
      <div class="overlay-text"><span class="highlight2">AT</span></div>
    </div>
    <div class="image-container">
      <img src="../image/Rectangle 68.png" alt="">
      <div class="overlay-text">10 AM – 20 PM</div>
    </div>
  </div>
</section>

<?php include 'komponen/footer.php'; ?>