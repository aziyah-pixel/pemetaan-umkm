<?php
require '../conn.php';

//tambah data
if ($_POST['aksi'] === 'tambah') {
  $pengurus = trim($_POST['pengurus']);
  $kode = trim($_POST['Kode_dapen']);

  if ($pengurus === '') {
    header("Location: ../../admin/pages/master-data/pengurus.php?error=kosong");
    exit;
  }

  $sql = "INSERT INTO pengurus (kode_daerah, pengurus) VALUES (:kode_dapen,:pengurus)";
  $stmt = $conn->prepare($sql);
  $stmt->execute([
    ':kode_dapen'  => $kode,
    ':pengurus'    => $pengurus
  ]);

  header("Location: ../../admin/pages/master-data/pengurus.php?msg=added");
  exit;
}

//edit data
if ($_POST['aksi'] === 'edit') {
    $id       = $_POST['id_pengurus'];
    $pengurus = trim($_POST['pengurus']);
  
    if ($pengurus === '') {
      header("Location: ../../admin/pages/master-data/pengurus.php?error=kosong");
      exit;
    }
  
    $sql = "UPDATE pengurus SET pengurus = :pengurus WHERE id_pengurus = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
      ':pengurus' => $pengurus,
      ':id'       => $id
    ]);
  
    header("Location: ../../admin/pages/master-data/pengurus.php?msg=updated");
    exit;
  }

  //hapus
  if ($_POST['aksi'] === 'hapus') {
    $id = $_POST['id_pengurus'];
  
    $sql = "DELETE FROM pengurus WHERE id_pengurus = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':id' => $id]);
  
    header("Location: ../../admin/pages/master-data/pengurus.php?msg=deleted");
    exit;
  }
  
  $search = trim($_GET['search'] ?? '');

  // Jika kosong
  if ($search === '') {
    header("Location: ../../admin/pages/master-data/pengurus.php?error=kosong");
    exit;
  }
  
  // Cek data
  $sql = "SELECT COUNT(*) FROM pengurus 
          WHERE pengurus LIKE :search 
          OR kode_daerah LIKE :search";
  
  $stmt = $conn->prepare($sql);
  $stmt->execute([
    ':search' => "%$search%"
  ]);
  
  $jumlah = $stmt->fetchColumn();
  
  // Redirect berdasarkan hasil
  if ($jumlah == 0) {
    header("Location: ../../admin/pages/master-data/pengurus.php?search=$search&msg=notfound");
  } else {
    header("Location: ../../admin/pages/master-data/pengurus.php?search=$search");
  }
  exit;


