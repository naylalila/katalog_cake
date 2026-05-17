<?php
// Helper functions untuk database operations

/**
 * Get all products from database
 */
function getAllProducts($conn) {
    $query = "SELECT p.*, k.nama_kategori FROM tb_produk p 
              LEFT JOIN tb_kategori k ON p.id_kategori = k.id_kategori 
              ORDER BY p.id_produk";
    return mysqli_query($conn, $query);
}

/**
 * Get product by ID
 */
function getProductById($conn, $id) {
    $id = mysqli_real_escape_string($conn, $id);
    $query = "SELECT p.*, k.nama_kategori FROM tb_produk p 
              LEFT JOIN tb_kategori k ON p.id_kategori = k.id_kategori 
              WHERE p.id_produk = $id";
    return mysqli_query($conn, $query);
}

/**
 * Get products by category
 */
function getProductsByCategory($conn, $category_id) {
    $category_id = mysqli_real_escape_string($conn, $category_id);
    $query = "SELECT p.*, k.nama_kategori FROM tb_produk p 
              LEFT JOIN tb_kategori k ON p.id_kategori = k.id_kategori 
              WHERE p.id_kategori = $category_id 
              ORDER BY p.id_produk";
    return mysqli_query($conn, $query);
}

/**
 * Get all categories
 */
function getAllCategories($conn) {
    $query = "SELECT * FROM tb_kategori ORDER BY nama_kategori";
    return mysqli_query($conn, $query);
}

/**
 * Check user login
 */
function checkUserLogin($conn, $email, $password) {
    $email = mysqli_real_escape_string($conn, $email);
    
    $query = "SELECT * FROM tb_users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);
    
    if($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        // Verify password (using password_verify if passwords are hashed)
        if(password_verify($password, $user['password'])) {
            return $user;
        } else if($user['password'] === $password) {
            // Fallback for unhashed passwords (not recommended)
            return $user;
        }
    }
    return false;
}

/**
 * Register new user
 */
function registerUser($conn, $nama, $email, $password, $nomer_hp = '', $alamat = '') {
    $nama = mysqli_real_escape_string($conn, $nama);
    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);
    $nomer_hp = mysqli_real_escape_string($conn, $nomer_hp);
    $alamat = mysqli_real_escape_string($conn, $alamat);
    
    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    $query = "INSERT INTO tb_users (nama, email, password, nomer_hp, alamat) 
              VALUES ('$nama', '$email', '$hashed_password', '$nomer_hp', '$alamat')";
    
    return mysqli_query($conn, $query);
}

/**
 * Get user by email
 */
function getUserByEmail($conn, $email) {
    $email = mysqli_real_escape_string($conn, $email);
    $query = "SELECT id_user, nama, email, nomer_hp, alamat FROM tb_users WHERE email = '$email'";
    return mysqli_query($conn, $query);
}

/**
 * Add product
 */
function addProduct($conn, $nama_produk, $id_kategori, $harga, $stock, $deskripsi, $gambar_produk) {
    $nama_produk = mysqli_real_escape_string($conn, $nama_produk);
    $id_kategori = mysqli_real_escape_string($conn, $id_kategori);
    $harga = mysqli_real_escape_string($conn, $harga);
    $stock = mysqli_real_escape_string($conn, $stock);
    $deskripsi = mysqli_real_escape_string($conn, $deskripsi);
    $gambar_produk = mysqli_real_escape_string($conn, $gambar_produk);
    
    $query = "INSERT INTO tb_produk (nama_produk, id_kategori, harga, stock, deskripsi, gambar_produk) 
              VALUES ('$nama_produk', '$id_kategori', '$harga', '$stock', '$deskripsi', '$gambar_produk')";
    
    return mysqli_query($conn, $query);
}

/**
 * Update product
 */
function updateProduct($conn, $id_produk, $nama_produk, $id_kategori, $harga, $stock, $deskripsi, $gambar_produk = null) {
    $id_produk = mysqli_real_escape_string($conn, $id_produk);
    $nama_produk = mysqli_real_escape_string($conn, $nama_produk);
    $id_kategori = mysqli_real_escape_string($conn, $id_kategori);
    $harga = mysqli_real_escape_string($conn, $harga);
    $stock = mysqli_real_escape_string($conn, $stock);
    $deskripsi = mysqli_real_escape_string($conn, $deskripsi);
    
    if($gambar_produk) {
        $gambar_produk = mysqli_real_escape_string($conn, $gambar_produk);
        $query = "UPDATE tb_produk SET nama_produk='$nama_produk', id_kategori='$id_kategori', 
                  harga='$harga', stock='$stock', deskripsi='$deskripsi', gambar_produk='$gambar_produk' 
                  WHERE id_produk='$id_produk'";
    } else {
        $query = "UPDATE tb_produk SET nama_produk='$nama_produk', id_kategori='$id_kategori', 
                  harga='$harga', stock='$stock', deskripsi='$deskripsi' 
                  WHERE id_produk='$id_produk'";
    }
    
    return mysqli_query($conn, $query);
}

/**
 * Delete product
 */
function deleteProduct($conn, $id_produk) {
    $id_produk = mysqli_real_escape_string($conn, $id_produk);
    $query = "DELETE FROM tb_produk WHERE id_produk = '$id_produk'";
    return mysqli_query($conn, $query);
}

/**
 * Format currency to IDR
 */
function formatIDR($amount) {
    return "Rp " . number_format($amount, 0, ',', '.');
}

/**
 * Escape string for database
 */
function escape($conn, $string) {
    return mysqli_real_escape_string($conn, $string);
}

?>
