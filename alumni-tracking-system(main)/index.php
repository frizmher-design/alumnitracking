<?php
session_start();

// If already logged in → go to dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard/index.php");
    exit();
}

// Otherwise → always go to login first
header("Location: auth/login.php");
exit();
?>