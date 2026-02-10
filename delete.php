<?php
include "config/db.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = intval($_GET['id']);

$result = mysqli_query($conn, "SELECT stored_name FROM files WHERE id='$id'");
$file = mysqli_fetch_assoc($result);

if ($file) {
    $file_path = "uploads/" . $file['stored_name'];

    if (file_exists($file_path)) {
        unlink($file_path);
    }

    mysqli_query($conn, "DELETE FROM files WHERE id='$id'");
}

header("Location: index.php?deleted=1");
exit();