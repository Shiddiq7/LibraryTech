<?php
require "func.php";
require "Auth/cek_log.php";

// Check if the user is logged in
if (isset($_SESSION['log'])) {
    // If logged in, redirect to the appropriate dashboard based on the user's role
    if ($_SESSION['role'] == 'Admin') {
        header('Location: Admin/dashboard.php');
    } else {
        header('Location: User/dashboard.php');
    }
    exit();
}
?>
