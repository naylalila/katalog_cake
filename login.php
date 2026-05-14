<?php
$page_css = "login.css";
include 'komponen/header.php';
?>

<section class="login-section">
    <div class="login-container">

        <!-- kiri -->
        <div class="login-left">
            <img src="image/about (2).png" alt="Bakery">
            <div class="overlay-text">
                <h1>Welcome Back!</h1>
                <p>Login to order your favorite bakery menu 🍰</p>
            </div>
        </div>

        <!-- kanan -->
        <div class="login-right">
            <h2>Login Account</h2>
            <p>Please login to continue your sweet journey ✨</p>

          <form action="landingpage.php" method="POST">
    
         <div class="input-group">
         <label>Email</label>
         <input type="email" name="email" placeholder="Enter your email">
          </div>

         <div class="input-group">
         <label>Password</label>
         <input type="password" name="password" placeholder="Enter your password">
         </div>
   
        <button type="submit" class="form-login-btn">Login</button>
         </form>
         </div>

         </div>
        </section>

<?php include 'komponen/footer.php'; ?>