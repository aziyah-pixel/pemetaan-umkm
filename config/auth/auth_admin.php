<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../login.php");
    exit;
}

// Cek role admin
if ($_SESSION['status'] !== 'admin') {
    header("Location: ../../operator/index.php");
    exit;
}
