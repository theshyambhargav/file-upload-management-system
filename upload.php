<?php
include "config/db.php";

$allowed_types = [
    "application/pdf",
    "image/jpeg",
    "image/png",
    "application/msword",
    "application/vnd.openxmlformats-officedocument.wordprocessingml.document"
];

$max_size = 5 * 1024 * 1024; // 5MB

if (isset($_FILES['file'])) {

    $file = $_FILES['file'];

    if ($file['error'] !== 0) {
        die("Upload error code: " . $file['error']);
    }

    if ($file['size'] > $max_size) {
        die("File exceeds 5MB limit.");
    }

    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime  = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);

    if (!in_array($mime, $allowed_types)) {
        die("Invalid file type.");
    }

    $original_name = basename($file['name']);
    $extension = pathinfo($original_name, PATHINFO_EXTENSION);

    $stored_name = uniqid() . "_" . time() . "." . $extension;

    if (!move_uploaded_file($file['tmp_name'], "uploads/" . $stored_name)) {
        die("Failed to move uploaded file.");
    }

    $safe_name = mysqli_real_escape_string($conn, $original_name);

    mysqli_query($conn, "INSERT INTO files 
        (original_name, stored_name, file_size, file_type)
        VALUES (
            '$safe_name',
            '$stored_name',
            '{$file['size']}',
            '$mime'
        )");

    header("Location: index.php?success=1");
    exit();
}

header("Location: index.php");
exit();