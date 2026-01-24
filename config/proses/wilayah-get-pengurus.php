<?php
require '../conn.php';

$kode = $_GET['kode_daerah'] ?? '';

$sql = "SELECT pengurus
        FROM pengurus
        WHERE kode_daerah = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$kode]);

echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
