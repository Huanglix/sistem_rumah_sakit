<?php
require_once "koneksi.php";
require_once "auth.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id        = (int) $_POST['id'];
    $hari      = isset($_POST['hari']) ? implode(',', $_POST['hari']) : '';
    $jam_mulai = mysqli_real_escape_string($koneksi, $_POST['jam_mulai']);
    $jam_selesai = mysqli_real_escape_string($koneksi, $_POST['jam_selesai']);
    $kuota     = (int) $_POST['kuota_pasien'];

    $query = "UPDATE tb_jadwal SET
                hari_praktik = '$hari',
                jam_mulai = '$jam_mulai',
                jam_selesai = '$jam_selesai',
                kuota_pasien = $kuota
              WHERE id = $id";

    if (mysqli_query($koneksi, $query)) {
        header("Location: jadwal_dokter.php?msg=edit");
        exit;
    } else {
        die("Gagal memperbarui jadwal: " . mysqli_error($koneksi));
    }
}
?>
