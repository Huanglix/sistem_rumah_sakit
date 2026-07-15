<?php
require_once "koneksi.php";
require_once "auth.php";

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    mysqli_query($koneksi, "DELETE FROM tb_dokter WHERE id = $id");
}

header("Location: data_dokter.php?msg=hapus");
exit;
?>
