<?php
require_once "../conn.php";
session_start();

/* ==========================
   AMBIL AKSI
========================== */
$aksi = $_POST['aksi'] == 'tambah';

/* ==========================
   TAMBAH UMKM
========================== */
if ($aksi == 'tambah') {

  // AMBIL DATA
  $kode_umkm           = $_POST['kode_umkm'];
  $nama_umkm           = $_POST['nama_umkm'];
  $nama_pemilik_umkm   = $_POST['nama_pemilik_umkm'];
  $nik_umkm            = $_POST['nik_umkm'];
  $no_hp_umkm          = $_POST['no_hp_umkm'];
  $email_umkm          = $_POST['email_umkm'];
  $jenis_usaha         = $_POST['jenis_usaha'];
  $kategori_usaha      = $_POST['kategori_usaha'];
  $wilayah_umkm        = $_POST['wilayah_umkm'];
  $kelurahan_umkm      = $_POST['kelurahan_umkm'];
  $rt_umkm             = $_POST['rt_umkm'];
  $rw_umkm             = $_POST['rw_umkm'];
  $alamat_umkm         = $_POST['alamat_umkm'];
  $operator         = $_POST['operator'];
 
  // UPLOAD FOTO
  $foto_umkm = $_FILES['foto_umkm'];
  $namaFoto = time() . "_" . $foto_umkm['name'];
  $path = "../../admin/asset/images/umkm/" . $namaFoto;

  move_uploaded_file($foto_umkm['tmp_name'], $path);

  // INSERT DATABASE
  $sql = "INSERT INTO umkm
  (kode_umkm, nama_umkm, nama_pemilik, nik, no_hp, email,
  jenis_usaha, kategori_usaha, wilayah,
  kelurahan, rt, rw, alamat, foto, operator)
  VALUES
  (:kode_umkm, :nama_umkm, :nama_pemilik_umkm, :nik_umkm, :no_hp_umkm, :email_umkm,
  :jenis_usaha, :kategori_usaha, :wilayah_umkm,
  :kelurahan_umkm, :rt_umkm, :rw_umkm, :alamat_umkm, :foto_umkm, :operator)";

  $stmt = $conn->prepare($sql);
  $stmt->execute([
    ':kode_umkm' => $kode_umkm,
    ':nama_umkm' => $nama_umkm,
    ':nama_pemilik_umkm' => $nama_pemilik_umkm,
    ':nik_umkm' => $nik_umkm,
    ':no_hp_umkm' => $no_hp_umkm,
    ':email_umkm' => $email_umkm,
    ':jenis_usaha' => $jenis_usaha,
    ':kategori_usaha' => $kategori_usaha,
    ':wilayah_umkm' => $wilayah_umkm,
    ':kelurahan_umkm' => $kelurahan_umkm,
    ':rt_umkm' => $rt_umkm,
    ':rw_umkm' => $rw_umkm,
    ':alamat_umkm' => $alamat_umkm,
    ':foto_umkm' => $namaFoto,
    ':operator' => $operator
  ]);

  header("Location: ../../admin/pages/data-umkm/data_umkm.php");
  exit;
}


