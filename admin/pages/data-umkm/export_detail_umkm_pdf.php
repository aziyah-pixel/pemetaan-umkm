<?php
require '../../../config/conn.php';
require '../../../assets/vendors/dompdf/autoload.inc.php';

use Dompdf\Dompdf;

$id = $_GET['id_umkm'] ?? null;
if (!$id) {
    die('ID UMKM tidak ditemukan');
}

// ambil data UMKM
$stmt = $conn->prepare("SELECT * FROM umkm WHERE id_umkm = ?");
$stmt->execute([$id]);
$umkm = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$umkm) {
    die('Data UMKM tidak ditemukan');
}

// HTML PDF
$html = '
<style>
body { font-family: Arial, sans-serif; font-size: 12px; }
h2 { text-align: center; }
table { width: 100%; border-collapse: collapse; margin-top: 20px; }
td { padding: 8px; border: 1px solid #ddd; }
.foto { text-align: center; }
.foto img { width: 150px; height: 150px; object-fit: cover; }
</style>

<h2>DETAIL DATA UMKM</h2>

<table>
<tr>
  <td colspan="2" class="foto">
    <img src="../../asset/images/umkm/'.($umkm['foto'] ?? 'default.jpg').'">
  </td>
</tr>
<tr>
  <td width="30%">Nama UMKM</td>
  <td>'.$umkm['nama_umkm'].'</td>
</tr>
<tr>
  <td>Pemilik</td>
  <td>'.$umkm['nama_pemilik'].'</td>
</tr>
<tr>
  <td>Jenis Usaha</td>
  <td>'.$umkm['jenis_usaha'].'</td>
</tr>
<tr>
  <td>Jenis Usaha</td>
  <td>'.$umkm['kategori_usaha'].'</td>
</tr>
<tr>
  <td>Wilayah</td>
  <td>'.$umkm['wilayah'].'</td>
</tr>
<tr>
  <td>Wilayah</td>
  <td>'.$umkm['kelurahan'].'</td>
</tr>
<tr>
  <td>Alamat</td>
  <td>'.$umkm['alamat'].'</td>
</tr>
</table>
';

// generate PDF
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// download otomatis
$dompdf->stream("detail_umkm_{$umkm['nama_umkm']}.pdf", [
    "Attachment" => true
]);
