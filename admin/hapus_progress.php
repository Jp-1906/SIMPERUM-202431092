<?php
include '../config/koneksi.php';

$id = $_GET['id'];

mysqli_query(
    $conn,
    "DELETE FROM progress_pembangunan
    WHERE id_progress='$id'"
);

header("Location: progress.php");
exit;
?>