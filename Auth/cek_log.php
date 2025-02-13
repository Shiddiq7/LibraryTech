<?php
if (!isset($_SESSION['log'])) {
    header('Location: http://localhost/librarytech/Auth/login.php') || header('Location: ../Auth/login.php');
    exit();
}


$role = $_SESSION['role'];
$currentUrl = $_SERVER['REQUEST_URI'];

if ($role == 'Anggota' && (strpos($currentUrl, '/Admin/') !== false || strpos($currentUrl, '/Auth/') !== false)) {
    header('Location: ../User/dashboard.php');
    exit();
}

if ($role == 'Admin' && (strpos($currentUrl, '/User/') !== false || strpos($currentUrl, '/Auth/') !== false)) {
    header('Location: ../Admin/dashboard.php');
    exit();
}
?>