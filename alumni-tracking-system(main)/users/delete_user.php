<?php
session_start();
include('../config/database.php');

// ADMIN ONLY
if($_SESSION['role'] != 'admin'){
    header("Location: ../dashboard/index.php");
    exit();
}

// CHECK ID
if(isset($_GET['id'])){
    $id = (int)$_GET['id'];

    // PREVENT SELF DELETE
    if($id == $_SESSION['user_id']){
        echo "<script>alert('You cannot delete your own account'); window.location='manage_users.php';</script>";
        exit();
    }

    // DELETE USER
    $stmt = $conn->prepare("DELETE FROM users WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

header("Location: manage_users.php");
exit();