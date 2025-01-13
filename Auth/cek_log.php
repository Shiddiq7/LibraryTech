<?php
if (isset($_SESSION['log'])) {
} else {
    if (headers_sent()) {
        header('location: login.php');
    } else {
        header('location: Auth/login.php');
    }
}
?>
