<?php
require '../../../config/conn.php';
require '../../../lib/fpdf/fpdf.php';

/* ===============================
   INIT PDF
================================ */
$pdf = new FPDF('L', 'mm', [330, 210]);
$pdf->AddPage();
$pdf->SetMargins(10, 10, 10);
$pdf->SetAutoPageBreak(true, 15);

/* ===============================
   JUDUL
================================ */
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'LAPORAN DATA UMKM', 0, 1, 'C');
$pdf->Ln(5);

/* ===============================
   LEBAR KOLOM
================================ */
$w = [
    10,  // No
    20,  // Kode
    30,  // Nama UMKM
    30,  // Pemilik
    25,  // NIK
    35,  // Email
    25,  // Kontak
    25,  // Jenis
    25,  // Kategori
    25,  // Wilayah
    55,  // Alamat
    20   // Operator
];

/* ===============================
   HEADER
================================ */
$pdf->SetFont('Arial', 'B', 9);
$pdf->SetFillColor(230,230,230);

$header = [
    'No','Kode','Nama UMKM','Pemilik','NIK','Email',
    'Kontak','Jenis','Kategori','Wilayah','Alamat','Operator'
];

foreach ($header as $i => $text) {
    $pdf->Cell($w[$i], 8, $text, 1, 0, 'C', true);
}
$pdf->Ln();

/* ===============================
   SQL (SESUI PERMINTAANMU)
================================ */
$sql = "
SELECT 
    u.kode_umkm,
    u.nama_umkm,
    u.nama_pemilik,
    u.nik,
    u.email,
    u.no_hp,
    u.kategori_usaha,
    u.alamat,
    u.operator,
    j.jenis_usaha,
    w.wilayah
FROM umkm u
LEFT JOIN jenis_usaha j ON u.id_usaha = j.id_usaha
LEFT JOIN wilayah w ON u.id_wilayah = w.id_wilayah
ORDER BY u.id_umkm ASC
";

$stmt = $conn->prepare($sql);
$stmt->execute();

/* ===============================
   ISI DATA (ANTI TABRAKAN)
================================ */
$pdf->SetFont('Arial', '', 9);
$no = 1;

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

    // Simpan posisi awal
    $x = $pdf->GetX();
    $y = $pdf->GetY();

    /* --- HITUNG TINGGI ALAMAT --- */
    $pdf->MultiCell($w[10], 7, $row['alamat'], 0);
    $rowHeight = $pdf->GetY() - $y;

    // Kembali ke awal baris
    $pdf->SetXY($x, $y);

    /* --- CETAK SEMUA KOLOM DENGAN TINGGI SAMA --- */
    $pdf->Cell($w[0],  $rowHeight, $no++, 1, 0, 'C');
    $pdf->Cell($w[1],  $rowHeight, $row['kode_umkm'], 1);
    $pdf->Cell($w[2],  $rowHeight, $row['nama_umkm'], 1);
    $pdf->Cell($w[3],  $rowHeight, $row['nama_pemilik'], 1);
    $pdf->Cell($w[4],  $rowHeight, $row['nik'], 1);
    $pdf->Cell($w[5],  $rowHeight, $row['email'], 1);
    $pdf->Cell($w[6],  $rowHeight, $row['no_hp'], 1);
    $pdf->Cell($w[7],  $rowHeight, $row['jenis_usaha'], 1);
    $pdf->Cell($w[8],  $rowHeight, $row['kategori_usaha'], 1);
    $pdf->Cell($w[9],  $rowHeight, $row['wilayah'], 1);

    // Alamat (baru pakai border)
    $pdf->MultiCell($w[10], 7, $row['alamat'], 1);

    // Operator
    $pdf->SetXY($x + array_sum(array_slice($w, 0, 11)), $y);
    $pdf->Cell($w[11], $rowHeight, $row['operator'], 1);

    // Pindah ke baris berikutnya
    $pdf->SetY($y + $rowHeight);
}

/* ===============================
   FOOTER
================================ */
$pdf->Ln(5);
$pdf->SetFont('Arial','I',8);
$pdf->Cell(0,8,'Dicetak pada: '.date('d-m-Y H:i'),0,0,'R');

/* ===============================
   OUTPUT
================================ */
$pdf->Output('I','Laporan_Data_UMKM.pdf');
