<?php
session_start();
session_destroy();
if (!headers_sent()) {
    header("Location: login.php");
    exit();
} else {
    header("Location: Auth/login.php");
    exit();
}
?>