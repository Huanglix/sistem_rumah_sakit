<?php
require_once "koneksi.php";
require_once "auth.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $periode   = mysqli_real_escape_string($koneksi, $_POST['periode']);
    $kunjungan = (int) $_POST['total_kunjungan'];
    $pendapatan = (float) $_POST['total_pendapatan'];
    $poli      = mysqli_real_escape_string($koneksi, $_POST['poliklinik_teraktif']);
    $rujukan   = (int) ($_POST['jumlah_rujukan'] ?? 0);
    $catatan   = mysqli_real_escape_string($koneksi, $_POST['catatan_evaluasi']);

    if (isset($_POST['id']) && $_POST['id'] !== '') {
        $id = (int) $_POST['id'];
        $query = "UPDATE tb_laporan SET
                    periode = '$periode',
                    total_kunjungan = $kunjungan,
                    total_pendapatan = $pendapatan,
                    poliklinik_teraktif = '$poli',
                    jumlah_rujukan = $rujukan,
                    catatan_evaluasi = '$catatan'
                  WHERE id = $id";
        mysqli_query($koneksi, $query);
    } else {
        $query = "INSERT INTO tb_laporan (periode, total_kunjungan, total_pendapatan, poliklinik_teraktif, jumlah_rujukan, catatan_evaluasi)
                  VALUES ('$periode', $kunjungan, $pendapatan, '$poli', $rujukan, '$catatan')";
        mysqli_query($koneksi, $query);
        $id = mysqli_insert_id($koneksi);
    }

    header("Location: hasil_laporan.php?id=" . $id);
    exit;
}
?>
