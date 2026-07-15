<?php
require_once "koneksi.php";
require_once "auth.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pasien_id = (int) $_POST['pasien_id'];
    $poli      = mysqli_real_escape_string($koneksi, $_POST['poliklinik']);
    $dokter_id = (int) $_POST['dokter_id'];
    $jenis     = mysqli_real_escape_string($koneksi, $_POST['jenis_pembiayaan']);

    // Generate no antrean sederhana, contoh: A26
    $totalHariIni = mysqli_fetch_assoc(mysqli_query($koneksi,
        "SELECT COUNT(*) as total FROM tb_pendaftaran WHERE tanggal_daftar = CURDATE()"))['total'];
    $noAntrean = 'A' . str_pad($totalHariIni + 1, 2, '0', STR_PAD_LEFT);

    $query = "INSERT INTO tb_pendaftaran (no_antrean, pasien_id, poliklinik, dokter_id, jenis_pembiayaan)
              VALUES ('$noAntrean', $pasien_id, '$poli', $dokter_id, '$jenis')";

    if (mysqli_query($koneksi, $query)) {
        header("Location: pendaftaran.php?msg=sukses&antrean=" . urlencode($noAntrean));
        exit;
    } else {
        die("Gagal menyimpan pendaftaran: " . mysqli_error($koneksi));
    }
}
?>
