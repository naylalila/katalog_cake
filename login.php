<?php
$page_css = "login.css";
include 'komponen/header.php';
include 'config/Database.php';
include 'config/functions.php';
include 'config/session.php';

// Redirect if already logged in
requireLogout();

$error = '';
$success = '';

// Handle login
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['login'])) {
        $db = new Database();
        $conn = $db->getConnection();
        
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        
        if(!empty($email) && !empty($password)) {
            $user = checkUserLogin($conn, $email, $password);
            
            if($user) {
                loginUser($user['id_user'], [
                    'nama' => $user['nama'],
                    'email' => $user['email'],
                    'nomer_hp' => $user['nomer_hp'] ?? '',
                    'alamat' => $user['alamat'] ?? ''
                ]);
                
                header("Location: landingpage.php");
                exit;
            } else {
                $error = "Email atau password salah!";
            }
        } else {
            $error = "Email dan password harus diisi!";
        }
    }
    // Handle register
    elseif(isset($_POST['register'])) {
        $db = new Database();
        $conn = $db->getConnection();
        
        $nama = $_POST['nama'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $password_confirm = $_POST['password_confirm'] ?? '';
        
        if(!empty($nama) && !empty($email) && !empty($password)) {
            if($password !== $password_confirm) {
                $error = "Password tidak cocok!";
            } else {
                // Check if email already exists
                $check_email = getUserByEmail($conn, $email);
                
                if($check_email && mysqli_num_rows($check_email) > 0) {
                    $error = "Email sudah terdaftar!";
                } else {
                    if(registerUser($conn, $nama, $email, $password)) {
                        $success = "Registrasi berhasil! Silahkan login.";
                    } else {
                        $error = "Terjadi kesalahan saat registrasi!";
                    }
                }
            }
        } else {
            $error = "Semua field harus diisi!";
        }
    }
}

// Determine which form to show
$show_register = isset($_GET['register']) ? true : false;
?>

<section class="login-section">
    <div class="login-container">

        <!-- kiri -->
        <div class="login-left">
            <img src="image/about (2).png" alt="Bakery">
            <div class="overlay-text">
                <h1><?php echo $show_register ? 'Welcome!' : 'Welcome Back!'; ?></h1>
                <p><?php echo $show_register ? 'Join us to order your favorite bakery menu 🍰' : 'Login to order your favorite bakery menu 🍰'; ?></p>
            </div>
        </div>

        <!-- kanan -->
        <div class="login-right">
            <?php if($error): ?>
                <div style="background-color: #fee; color: #c00; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
            
            <?php if($success): ?>
                <div style="background-color: #efe; color: #080; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
                    <?php echo $success; ?>
                </div>
            <?php endif; ?>

            <?php if($show_register): ?>
                <!-- FORM REGISTER -->
                <h2>Create Account</h2>
                <p>Join us for a sweet experience ✨</p>

                <form action="login.php" method="POST">
                    <div class="input-group">
                        <label>Full Name</label>
                        <input type="text" name="nama" placeholder="Enter your full name" required>
                    </div>

                    <div class="input-group">
                        <label>Email</label>
                        <input type="email" name="email" placeholder="Enter your email" required>
                    </div>

                    <div class="input-group">
                        <label>Password</label>
                        <input type="password" name="password" placeholder="Enter your password" required>
                    </div>

                    <div class="input-group">
                        <label>Confirm Password</label>
                        <input type="password" name="password_confirm" placeholder="Confirm your password" required>
                    </div>

                    <button type="submit" name="register" class="form-login-btn">Register</button>
                </form>

                <p style="margin-top: 15px;">Already have an account? <a href="login.php" style="color: #d4a574;">Login here</a></p>
            <?php else: ?>
                <!-- FORM LOGIN -->
                <h2>Login Account</h2>
                <p>Please login to continue your sweet journey ✨</p>

                <form action="login.php" method="POST">
                    <div class="input-group">
                        <label>Email</label>
                        <input type="email" name="email" placeholder="Enter your email" required>
                    </div>

                    <div class="input-group">
                        <label>Password</label>
                        <input type="password" name="password" placeholder="Enter your password" required>
                    </div>

                    <button type="submit" name="login" class="form-login-btn">Login</button>
                </form>

                <p style="margin-top: 15px;">Don't have an account? <a href="login.php?register=1" style="color: #d4a574;">Register here</a></p>
            <?php endif; ?>
         </div>

         </div>
        </section>

<?php include 'komponen/footer.php'; ?>