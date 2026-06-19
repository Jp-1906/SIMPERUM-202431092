<?php
include '../config/koneksi.php';

$id = $_GET['id'];

mysqli_query($conn,
    "DELETE FROM rumah WHERE id_rumah='$id'"
);

header("Location: rumah.php");
exit;
?>