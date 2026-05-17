<?php
include 'config/Database.php';

$db = new Database();
$conn = $db->getConnection();

echo "<h1>Test Database Connection</h1>";

// Test 1: Connection
if($conn){
    echo "<h3 style='color: green;'>✓ Database berhasil terkoneksi!</h3>";
} else {
    echo "<h3 style='color: red;'>✗ Database gagal terkoneksi!</h3>";
    exit;
}

// Test 2: Check Tables
echo "<h3>Daftar Tabel:</h3>";
$tables_query = "SHOW TABLES";
$tables_result = mysqli_query($conn, $tables_query);

if($tables_result){
    echo "<ul>";
    while($table = mysqli_fetch_array($tables_result)){
        echo "<li>" . $table[0] . "</li>";
    }
    echo "</ul>";
}

// Test 3: Check Kategori Data
echo "<h3>Data Kategori:</h3>";
$kategori_query = "SELECT * FROM tb_kategori";
$kategori_result = mysqli_query($conn, $kategori_query);

if($kategori_result && mysqli_num_rows($kategori_result) > 0){
    echo "<table border='1' cellpadding='10'>";
    echo "<tr><th>ID Kategori</th><th>Nama Kategori</th></tr>";
    while($row = mysqli_fetch_assoc($kategori_result)){
        echo "<tr><td>" . $row['id_kategori'] . "</td><td>" . $row['nama_kategori'] . "</td></tr>";
    }
    echo "</table>";
} else {
    echo "<p>Tidak ada data kategori atau query error: " . mysqli_error($conn) . "</p>";
}

// Test 4: Check Produk Data
echo "<h3>Data Produk:</h3>";
$produk_query = "SELECT p.*, k.nama_kategori FROM tb_produk p 
                 LEFT JOIN tb_kategori k ON p.id_kategori = k.id_kategori";
$produk_result = mysqli_query($conn, $produk_query);

if($produk_result && mysqli_num_rows($produk_result) > 0){
    echo "<table border='1' cellpadding='10'>";
    echo "<tr><th>ID</th><th>Nama Produk</th><th>Kategori</th><th>Harga</th><th>Stock</th><th>Deskripsi</th></tr>";
    while($row = mysqli_fetch_assoc($produk_result)){
        echo "<tr>
                <td>" . $row['id_produk'] . "</td>
                <td>" . $row['nama_produk'] . "</td>
                <td>" . $row['nama_kategori'] . "</td>
                <td>Rp " . number_format($row['harga'], 2, ',', '.') . "</td>
                <td>" . $row['stock'] . "</td>
                <td>" . $row['deskripsi'] . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p>Tidak ada data produk atau query error: " . mysqli_error($conn) . "</p>";
}

// Test 5: Check Users Table
echo "<h3>Data Users:</h3>";
$users_query = "SELECT id_user, nama, email, created_at FROM tb_users";
$users_result = mysqli_query($conn, $users_query);

if($users_result){
    $user_count = mysqli_num_rows($users_result);
    echo "<p>Total users: " . $user_count . "</p>";
    if($user_count > 0){
        echo "<table border='1' cellpadding='10'>";
        echo "<tr><th>ID</th><th>Nama</th><th>Email</th><th>Terdaftar</th></tr>";
        while($row = mysqli_fetch_assoc($users_result)){
            echo "<tr>
                    <td>" . $row['id_user'] . "</td>
                    <td>" . $row['nama'] . "</td>
                    <td>" . $row['email'] . "</td>
                    <td>" . $row['created_at'] . "</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Database siap, tapi belum ada user yang terdaftar.</p>";
    }
}

mysqli_close($conn);
?>

<style>
    body { font-family: Arial, sans-serif; margin: 20px; }
    table { border-collapse: collapse; margin: 20px 0; }
    h3 { color: #333; }
    li { margin: 5px 0; }
</style>