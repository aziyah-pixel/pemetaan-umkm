<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../../login.php");
    exit;
}

// Cek role operator
if ($_SESSION['status'] !== 'operator') {
    header("Location: ../../admin/index.php");
    exit;
}
