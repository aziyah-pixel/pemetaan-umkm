<?php
require_once "../conn.php";
session_start();

/* ==========================
   AMBIL AKSI
========================== */
$aksi = $_POST['aksi'];

/* ==========================
   TAMBAH UMKM
========================== */
if ($aksi === 'tambah') {

  /* ==========================
     VALIDASI INPUT WAJIB
  ========================== */
  $required = [
    'kode_umkm',
    'nama_umkm',
    'nama_pemilik_umkm',
    'nik_umkm',
    'no_hp_umkm',
    'email_umkm',
    'jenis_usaha',
    'kategori_usaha',
    'wilayah_umkm',
    'kelurahan_umkm',
    'rt_umkm',
    'rw_umkm',
    'alamat_umkm',
    'operator'
  ];

  foreach ($required as $field) {
    if (empty(trim($_POST[$field] ?? ''))) {
      header("Location: ../../admin/pages/data-umkm/tambah_umkm.php?error=field_kosong");
      exit;
    }
  }

  /* ==========================
     AMBIL DATA
  ========================== */
  $kode_umkm         = trim($_POST['kode_umkm']);
  $nama_umkm         = trim($_POST['nama_umkm']);
  $nama_pemilik_umkm = trim($_POST['nama_pemilik_umkm']);
  $nik_umkm          = trim($_POST['nik_umkm']);
  $no_hp_umkm        = trim($_POST['no_hp_umkm']);
  $email_umkm        = trim($_POST['email_umkm']);
  $jenis_usaha       = trim($_POST['jenis_usaha']);
  $kategori_usaha    = trim($_POST['kategori_usaha']);
  $wilayah_umkm      = trim($_POST['wilayah_umkm']);
  $kelurahan_umkm    = trim($_POST['kelurahan_umkm']);
  $rt_umkm           = trim($_POST['rt_umkm']);
  $rw_umkm           = trim($_POST['rw_umkm']);
  $alamat_umkm       = trim($_POST['alamat_umkm']);
  $operator          = trim($_POST['operator']);

  /* ==========================
     PROSES FOTO
  ========================== */
  $defaultFoto = "default-image.jpeg";
  $namaFoto = $defaultFoto;

  if (
    isset($_FILES['foto_umkm']) &&
    $_FILES['foto_umkm']['error'] === UPLOAD_ERR_OK
  ) {

    $allowedExt = ['jpg', 'jpeg', 'png'];
    $ext = strtolower(pathinfo($_FILES['foto_umkm']['name'], PATHINFO_EXTENSION));

    if (!in_array($ext, $allowedExt)) {
      header("Location: ../../admin/pages/data-umkm/tambah_umkm.php?error=format_foto");
      exit;
    }

    if ($_FILES['foto_umkm']['size'] > 2 * 1024 * 1024) {
      header("Location: ../../admin/pages/data-umkm/tambah_umkm.php?error=ukuran_foto");
      exit;
    }

    $namaFoto = time() . "_" . uniqid() . "." . $ext;
    $path = "../../admin/asset/images/umkm/" . $namaFoto;

    if (!move_uploaded_file($_FILES['foto_umkm']['tmp_name'], $path)) {
      header("Location: ../../admin/pages/data-umkm/tambah_umkm.php?error=upload_gagal");
      exit;
    }
  }

  /* ==========================
     INSERT DATABASE
  ========================== */
  $sql = "INSERT INTO umkm (
      kode_umkm, nama_umkm, nama_pemilik, nik, no_hp, email,
      id_usaha, kategori_usaha, id_wilayah,
      kelurahan, rt, rw, alamat, foto, operator
    ) VALUES (
      :kode_umkm, :nama_umkm, :nama_pemilik, :nik, :no_hp, :email,
      :jenis_usaha, :kategori_usaha, :wilayah,
      :kelurahan, :rt, :rw, :alamat, :foto, :operator
    )";

  $stmt = $conn->prepare($sql);
  $stmt->execute([
    ':kode_umkm'    => $kode_umkm,
    ':nama_umkm'    => $nama_umkm,
    ':nama_pemilik' => $nama_pemilik_umkm,
    ':nik'          => $nik_umkm,
    ':no_hp'        => $no_hp_umkm,
    ':email'        => $email_umkm,
    ':jenis_usaha'  => $jenis_usaha,
    ':kategori_usaha'=> $kategori_usaha,
    ':wilayah'      => $wilayah_umkm,
    ':kelurahan'    => $kelurahan_umkm,
    ':rt'           => $rt_umkm,
    ':rw'           => $rw_umkm,
    ':alamat'       => $alamat_umkm,
    ':foto'         => $namaFoto,
    ':operator'     => $operator
  ]);

  header("Location: ../../admin/pages/data-umkm/data_umkm.php?msg=added");
  exit;
}

// -------------------
// EDIT UMKM
// -------------------
if ($aksi == 'edit') {

  $id_umkm     = $_POST['id_umkm'];
  $nama_umkm   = $_POST['nama_umkm'];
  $pemilik     = $_POST['pemilik'];
  $nik         = $_POST['nik'];
  $no_hp       = $_POST['no_hp'];
  $email       = $_POST['email'];
  $jenis_usaha = $_POST['jenis_usaha'];
  $kategori    = $_POST['kategori_usaha'];
  $wilayah     = $_POST['wilayah_umkm'];
  $kelurahan   = $_POST['kelurahan_umkm'];
  $rt          = $_POST['rt_umkm'];
  $rw          = $_POST['rw_umkm'];
  $alamat      = $_POST['alamat_umkm'];

  // FOTO
  if (!empty($_FILES['foto']['name'])) {

      $foto = time().'_'.$_FILES['foto']['name'];
      $tmp  = $_FILES['foto']['tmp_name'];

      move_uploaded_file($tmp, '../../admin/asset/images/umkm/'.$foto);

      $sql = "UPDATE umkm SET 
              nama_umkm    = :nama,
              nama_pemilik = :pemilik,
              nik          = :nik,
              no_hp        = :no_hp,
              email        = :email,
              id_usaha  = :jenis,
              kategori_usaha     = :kategori,
              id_wilayah      = :wilayah,
              kelurahan    = :kelurahan,
              rt           = :rt,
              rw           = :rw,
              alamat       = :alamat,
              foto         = :foto
              WHERE id_umkm = :id";

      $stmt = $conn->prepare($sql);
      $stmt->execute([
          ':nama'    => $nama_umkm,
          ':pemilik' => $pemilik,
          ':nik' => $nik,
          ':no_hp'   => $no_hp,
          ':email'   => $email,
          ':jenis'   => $jenis_usaha,
          ':kategori'=> $kategori,
          ':wilayah' => $wilayah,
          ':kelurahan' => $kelurahan,
          ':rt' => $rt,
          ':rw' => $rw,
          ':alamat'  => $alamat,
          ':foto'    => $foto,
          ':id'      => $id_umkm
      ]);

  } else {
//tanpa foto
      $sql = "UPDATE umkm SET 
              nama_umkm    = :nama,
              nama_pemilik = :pemilik,
              nik          = :nik,
              no_hp        = :no_hp,
              email        = :email,
              id_usaha  = :jenis,
              kategori_usaha     = :kategori,
              id_wilayah      = :wilayah,
              kelurahan    = :kelurahan,
              rt           = :rt,
              rw           = :rw,
              alamat       = :alamat
              WHERE id_umkm = :id";

      $stmt = $conn->prepare($sql);
      $stmt->execute([
        ':nama'    => $nama_umkm,
        ':pemilik' => $pemilik,
        ':nik' => $nik,
        ':no_hp'   => $no_hp,
        ':email'   => $email,
        ':jenis'   => $jenis_usaha,
        ':kategori'=> $kategori,
        ':wilayah' => $wilayah,
        ':kelurahan' => $kelurahan,
        ':rt' => $rt,
        ':rw' => $rw,
        ':alamat'  => $alamat,
        ':id'      => $id_umkm
      ]);
  }

  header("Location: ../../admin/pages/data-umkm/detail_umkm.php?id_umkm=$id_umkm&msg=update");
  exit;
}


// -------------------
// HAPUS UMKM
// -------------------
if (isset($_GET['aksi']) && $_GET['aksi'] === 'hapus') {

  if (!isset($_GET['id_umkm'])) {
      header("Location: ../../admin/pages/data-umkm/data_umkm.php");
      exit;
  }

  $id_umkm = $_GET['id_umkm'];

  // Ambil foto dulu
  $cek = $conn->prepare("SELECT foto FROM umkm WHERE id_umkm = ?");
  $cek->execute([$id_umkm]);
  $data = $cek->fetch(PDO::FETCH_ASSOC);

  if ($data) {

      // Hapus file foto
      if (!empty($data['foto'])) {
          $path = "../../asset/images/umkm/" . $data['foto'];
          if (file_exists($path)) {
              unlink($path);
          }
      }

      // Hapus data database
      $hapus = $conn->prepare("DELETE FROM umkm WHERE id_umkm = ?");
      $hapus->execute([$id_umkm]);
  }

  header("Location: ../../admin/pages/data-umkm/data_umkm.php?msg=deleted");
  exit;
}

$search = trim($_GET['search'] ?? '');

// Jika kosong
if ($search === '') {
  header("Location: ../../admin/pages/data-umkm/data_umkm.php?error=kosong");
  exit;
}

// Cek data
$sql = "SELECT COUNT(*) FROM umkm 
        WHERE nama_umkm LIKE :search 
        OR kode_umkm LIKE :search";

$stmt = $conn->prepare($sql);
$stmt->execute([
  ':search' => "%$search%"
]);

$jumlah = $stmt->fetchColumn();

// Redirect berdasarkan hasil
if ($jumlah == 0) {
  header("Location: ../../admin/pages/data-umkm/data_umkm.php?search=$search&msg=notfound");
} else {
  header("Location: ../../admin/pages/data-umkm/data_umkm.php?search=$search");
}
exit;

?>