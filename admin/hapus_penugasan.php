<?php
include '../config/koneksi.php';

$id = $_GET['id'];

mysqli_query(
    $conn,
    "DELETE FROM penugasan_tukang
     WHERE id_penugasan='$id'"
);

header("Location: penugasan.php");
exit;
?>