<?php
require_once "koneksi.php";
require_once "auth.php";

if (isset($_GET['id']) && isset($_GET['status'])) {
    $id = (int) $_GET['id'];
    $statusAllowed = ['Menunggu','Diracik','Siap Diambil','Selesai Diserahkan'];
    $status = $_GET['status'];

    if (in_array($status, $statusAllowed)) {
        $status = mysqli_real_escape_string($koneksi, $status);
        mysqli_query($koneksi, "UPDATE tb_resep SET status_racik = '$status' WHERE id = $id");
    }
}

header("Location: resep_detail.php?id=" . (int) $_GET['id']);
exit;
?>
