<?php
require '../conn.php';

$aksi = $_POST['aksi'] ?? '';

/* ==========================
   TAMBAH WILAYAH
========================== */
if ($aksi === 'tambah') {

  $wilayah     = $_POST['nama_wilayah'];
  $dapen = $_POST['dapen'];
  $pengurus = $_POST['pengurus'];

  if (!$wilayah || !$dapen || !$pengurus) {
    header("Location: ../../admin/pages/master-data/wilayah.php?error=kosong");
    exit;
  }

  $sql = "INSERT INTO wilayah (wilayah, dapen, pengurus)
          VALUES (?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->execute([$wilayah, $dapen, $pengurus]);

  header("Location: ../../admin/pages/master-data/wilayah.php?msg=added");
  exit;
}

/* ==========================
   EDIT WILAYAH
========================== */
if ($aksi === 'edit') {

  $id_wilayah  = $_POST['id_wilayah'];
  $wilayah     = $_POST['wilayah'];
  $kode_daerah = $_POST['kode_daerah'];
  $pengurus = $_POST['pengurus'];

  if (!$id_wilayah || !$wilayah || !$kode_daerah || !$pengurus) {
    header("Location: ../../admin/pages/master-data/wilayah.php?error=kosong");
    exit;
  }

  $sql = "UPDATE wilayah
          SET wilayah = ?, dapen = ?, pengurus = ?
          WHERE id_wilayah = ?";
  $stmt = $conn->prepare($sql);
  $stmt->execute([$wilayah, $kode_daerah, $pengurus, $id_wilayah]);

  header("Location: ../../admin/pages/master-data/wilayah.php?msg=updated");
  exit;
}

/* ==========================
   Hapus WILAYAH
========================== */
if ($aksi === 'hapus') {
  $id = $_POST['id_wilayah'];

  $sql = "DELETE FROM wilayah WHERE id_wilayah = :id";
  $stmt = $conn->prepare($sql);
  $stmt->execute([':id' => $id]);

  header("Location: ../../admin/pages/master-data/wilayah.php?msg=deleted");
  exit;
}
?>