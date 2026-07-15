<?php
require_once "koneksi.php";
require_once "auth.php";

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    mysqli_query($koneksi, "DELETE FROM tb_jadwal WHERE id = $id");
}

header("Location: jadwal_dokter.php?msg=hapus");
exit;
?>
