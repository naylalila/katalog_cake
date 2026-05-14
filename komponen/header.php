<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" href="style.css">

<?php if(isset($page_css)) : ?>
<link rel="stylesheet" href="<?php echo $page_css; ?>">
<?php endif; ?>

    <title>Deli Bakery</title>
</head>
<body>

<header>
  <div class="navbar">
    
    <div class="navbar-left">
      <div class="logo">🍞 Deli Bakery</div>

      <nav>
        <a href="landingpage.php">Home</a>
        <a href="shopall.php">Menu</a>
        <a href="information.php">About us</a>
      </nav>
    </div>

    <div class="actions">
    <a href="login.php" class="login">Login/Sign up</a>
    <a href="shopall.php" class="order">Order now</a>
    </div>

     </div>
</header>