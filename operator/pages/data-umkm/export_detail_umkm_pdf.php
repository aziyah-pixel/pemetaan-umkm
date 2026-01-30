<?php
require '../../../config/conn.php';
require '../../../lib/fpdf/fpdf.php';

/* =========================
   VALIDASI ID
========================= */
if (!isset($_GET['id_umkm']) || empty($_GET['id_umkm'])) {
    header("Location: data_umkm.php?pilih=true");
    exit;
}

$id_umkm = $_GET['id_umkm'];

/* =========================
   AMBIL DATA
========================= */
$sql = "SELECT 
            u.*,
            w.wilayah,
            j.jenis_usaha
        FROM umkm u
        LEFT JOIN wilayah w ON u.id_wilayah = w.id_wilayah
        LEFT JOIN jenis_usaha j ON u.id_usaha = j.id_usaha
        WHERE u.id_umkm = ?
        LIMIT 1";

$stmt = $conn->prepare($sql);
$stmt->execute([$id_umkm]);
$umkm = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$umkm) {
    header("Location: data_umkm.php?notfound=true");
    exit;
}

/* =========================
   FOTO
========================= */
$fotoDir = '../../asset/images/umkm/';
$foto = (!empty($umkm['foto']) && file_exists($fotoDir.$umkm['foto']))
        ? $fotoDir.$umkm['foto']
        : $fotoDir.'default.jpg';

/* =========================
   INIT PDF
========================= */
$pdf = new FPDF('P','mm','A4');
$pdf->AddPage();
$pdf->SetAutoPageBreak(false);

/* =========================
   JUDUL (RATA KIRI)
========================= */
$pdf->SetFont('Arial','B',14);
$pdf->Cell(0,8,'DETAIL DATA UMKM',0,1,'L');
$pdf->Ln(4);

/* =========================
   FOTO (TENGAH)
========================= */
$fotoWidth = 40;
$xFoto = (210 - $fotoWidth) / 2;
$pdf->Image($foto, $xFoto, $pdf->GetY(), $fotoWidth);
$pdf->Ln(45);

/* =========================
   NAMA UMKM
========================= */
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,8,$umkm['nama_umkm'],0,1,'C');
$pdf->Ln(2);

/* =========================
   DATA UMKM (PADAT)
========================= */
$pdf->SetFont('Arial','',10);

function row($pdf, $label, $value) {
    $pdf->Cell(45,7,$label,0,0);
    $pdf->MultiCell(0,7,": ".$value,0);
}

row($pdf,"Nama Pemilik",$umkm['nama_pemilik']);
row($pdf,"NIK",$umkm['nik']);
row($pdf,"No HP",$umkm['no_hp']);
row($pdf,"Email",$umkm['email']);
row($pdf,"Jenis Usaha",$umkm['jenis_usaha']);
row($pdf,"Kategori",$umkm['kategori_usaha']);
row($pdf,"Wilayah",$umkm['wilayah']);
row($pdf,"Kelurahan",$umkm['kelurahan']);

$pdf->Ln(3);

/* =========================
   ALAMAT
========================= */
$pdf->SetFont('Arial','B',11);
$pdf->Cell(0,7,'Alamat UMKM',0,1);

$pdf->SetFont('Arial','',10);
$pdf->MultiCell(0,7,$umkm['alamat']);

/* =========================
   FOOTER
========================= */
$pdf->SetY(-15);
$pdf->SetFont('Arial','I',9);
$pdf->Cell(0,10,'Dicetak: '.date('d-m-Y H:i'),0,0,'R');

/* =========================
   OUTPUT
========================= */
$pdf->Output('I','Detail_UMKM_'.$umkm['id_umkm'].'.pdf');
