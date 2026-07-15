<?php
require_once "koneksi.php";
require_once "auth.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dokter_id = (int) $_POST['dokter_id'];
    $hari      = isset($_POST['hari']) ? implode(',', $_POST['hari']) : '';
    $jam_mulai = mysqli_real_escape_string($koneksi, $_POST['jam_mulai']);
    $jam_selesai = mysqli_real_escape_string($koneksi, $_POST['jam_selesai']);
    $kuota     = (int) $_POST['kuota_pasien'];

    $query = "INSERT INTO tb_jadwal (dokter_id, hari_praktik, jam_mulai, jam_selesai, kuota_pasien)
              VALUES ($dokter_id, '$hari', '$jam_mulai', '$jam_selesai', $kuota)";

    if (mysqli_query($koneksi, $query)) {
        header("Location: jadwal_dokter.php?msg=tambah");
        exit;
    } else {
        die("Gagal menyimpan jadwal: " . mysqli_error($koneksi));
    }
}
?>
