<?php
include '../config/koneksi.php';

$id = $_GET['id'];

mysqli_query($conn,
    "DELETE FROM tukang WHERE id_tukang='$id'"
);

header("Location: tukang.php");
exit;
?>
