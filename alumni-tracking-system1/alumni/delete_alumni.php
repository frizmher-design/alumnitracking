<?php
include('../config/database.php');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $stmt = $conn->prepare("DELETE FROM alumni WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

header("Location: view_alumni.php");
exit();
?>