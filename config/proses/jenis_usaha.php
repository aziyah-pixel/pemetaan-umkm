<?php
require '../conn.php';

//tambah data
if ($_POST['aksi'] === 'tambah') {
  $jenis = trim($_POST['jenis']);
  $kode = trim($_POST['kode_usaha']);

  if ($jenis === '') {
    header("Location: ../../admin/pages/master-data/jenis_usaha.php?error=kosong");
    exit;
  }

  $sql = "INSERT INTO jenis_usaha (kode_usaha, jenis_usaha) VALUES (:kode_usaha,:jenis)";
  $stmt = $conn->prepare($sql);
  $stmt->execute([
    ':kode_usaha'  => $kode,
    ':jenis'    => $jenis
  ]);

  header("Location: ../../admin/pages/master-data/jenis_usaha.php?msg=added");
  exit;
}

//hapus
if ($_POST['aksi'] === 'hapus') {
  $id = $_POST['id_usaha'];

  $sql = "DELETE FROM jenis_usaha WHERE id_usaha = :id";
  $stmt = $conn->prepare($sql);
  $stmt->execute([':id' => $id]);

  header("Location: ../../admin/pages/master-data/jenis_usaha.php?msg=deleted");
  exit;
}

$search = trim($_GET['search'] ?? '');

// Jika kosong
if ($search === '') {
  header("Location: ../../admin/pages/master-data/jenis_data.php?error=kosong");
  exit;
}


// Cek data
$sql = "SELECT COUNT(*) FROM jenis_usaha 
WHERE jenis_usaha LIKE :search 
OR kode_usaha LIKE :search";

$stmt = $conn->prepare($sql);
$stmt->execute([
':search' => "%$search%"
]);

$jumlah = $stmt->fetchColumn();

// Redirect berdasarkan hasil
if ($jumlah == 0) {
header("Location: ../../admin/pages/master-data/jenis_usaha.php?search=$search&msg=notfound");
} else {
header("Location: ../../admin/pages/master-data/jenis_usaha.php?search=$search");
}
exit;

?>