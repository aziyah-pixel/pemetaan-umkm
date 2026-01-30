<?php
require '../../../config/conn.php';
require '../../../lib/fpdf/fpdf.php';

$pdf = new FPDF('L','mm','A4');
$pdf->AddPage();
$pdf->SetAutoPageBreak(true, 15);

/* ===============================
   JUDUL
================================ */
$pdf->SetFont('Arial','B',14);
$pdf->Cell(0,10,'DATA OPERATOR',0,1,'C');
$pdf->Ln(5);

/* ===============================
   LEBAR KOLOM
================================ */
$w = [
    10,  // No
    45,  // Nama Lengkap
    40,  // Username
    65,  // Email
    65,  // Alamat
    25   // Status
];

$totalWidth = array_sum($w);

/* ===============================
   POSISI TENGAH HALAMAN
================================ */
$pageWidth = $pdf->GetPageWidth();
$startX = ($pageWidth - $totalWidth) / 2;

/* ===============================
   HEADER TABEL
================================ */
$pdf->SetFont('Arial','B',10);
$pdf->SetFillColor(230,230,230);

$pdf->SetX($startX);
$pdf->Cell($w[0],8,'No',1,0,'C',true);
$pdf->Cell($w[1],8,'Nama Lengkap',1,0,'C',true);
$pdf->Cell($w[2],8,'Username',1,0,'C',true);
$pdf->Cell($w[3],8,'Email',1,0,'C',true);
$pdf->Cell($w[4],8,'Alamat',1,0,'C',true);
$pdf->Cell($w[5],8,'Status',1,1,'C',true);

/* ===============================
   DATA TABEL
================================ */
$pdf->SetFont('Arial','',10);

$query = $conn->query("SELECT * FROM penguna ORDER BY id_penguna ASC");
$no = 1;

while ($row = $query->fetch(PDO::FETCH_ASSOC)) {

    $pdf->SetX($startX);
    $pdf->Cell($w[0],8,$no++,1,0,'C');
    $pdf->Cell($w[1],8,$row['nama_penguna'],1);
    $pdf->Cell($w[2],8,$row['username'],1);
    $pdf->Cell($w[3],8,$row['email_penguna'],1);
    $pdf->Cell($w[4],8,$row['alamat_penguna'],1);
    $pdf->Cell($w[5],8,$row['status'],1,1,'C');
}

/* ===============================
   OUTPUT
================================ */
$pdf->Output('I','Data_Operator.pdf');
