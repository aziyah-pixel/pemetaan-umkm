<?php
require '../conn.php';
session_start();

//-------------------
//LOGIN
//-------------------
if ($_POST['aksi'] == 'login') { 

$username = $_POST['username'];
$password = $_POST['password'];

// 1. Cari user berdasarkan username
$sql = "SELECT * FROM penguna WHERE username = :username LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->execute([':username' => $username]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

// 2. Cek user
if ($user) {

    // 3. Verifikasi password hash
    if (password_verify($password, $user['password'])) {

        // 4. Set session
        $_SESSION['login']         = true;
        $_SESSION['id_penguna']    = $user['id_penguna'];
        $_SESSION['nama_penguna']  = $user['nama_penguna'];
        $_SESSION['status']        = $user['status'];

        // 5. Redirect sesuai role
        if ($user['status'] === 'admin') {
            header("Location: ../../admin/index.php");
        } else {
            header("Location: ../../operator/index.php");
        }
        exit;

    } else {
        header("Location: login.php?error=password");
        exit;
    }

} else {
    header("Location: login.php?error=username");
    exit;
}
}

//-------------------
// REGISTER
//-------------------
if ($_POST['aksi'] == 'register') {  
$nama_penguna     = $_POST['nama_penguna'];
$username         = $_POST['username'];
$alamat_penguna   = $_POST['alamat_penguna'];
$email_penguna    = $_POST['email_penguna'];
$password         = $_POST['password'];
$role             = $_POST['role'];

// HASH PASSWORD (WAJIB)
$hashPassword = password_hash($password, PASSWORD_DEFAULT);


// CEK USERNAME / EMAIL
$cek = $conn->prepare("SELECT * FROM penguna WHERE username = ? OR email_penguna = ?");
$cek->execute([$username, $email_penguna]);

if ($cek->rowCount() > 0) {
    echo "<script>alert('Username atau Email sudah digunakan');window.location='../register.php';</script>";
    exit;
}

// INSERT DATA
$sql = "INSERT INTO penguna (nama_penguna, username, alamat_penguna, email_penguna, password, status)
        VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->execute([
    $nama_penguna,
    $username,
    $alamat_penguna,
    $email_penguna,
    $hashPassword,
    $role
]);

echo "<script>alert('Registrasi berhasil');window.location='../../login.php';</script>";

}

