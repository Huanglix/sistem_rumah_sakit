<?php
require_once "koneksi.php";
require_once "auth.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pendaftaran_id = (int) $_POST['pendaftaran_id'];
    $total     = (float) $_POST['total_tagihan'];
    $metode    = mysqli_real_escape_string($koneksi, $_POST['metode_pembayaran']);
    $no_rek    = mysqli_real_escape_string($koneksi, $_POST['no_rekening']);
    $status    = mysqli_real_escape_string($koneksi, $_POST['status_transaksi']);
    $ket       = mysqli_real_escape_string($koneksi, $_POST['keterangan']);

    // Ambil nama pasien untuk nama_pembayar
    $pasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT ps.nama_pasien, ps.id as pasien_id
                                                           FROM tb_pendaftaran pd
                                                           JOIN tb_pasien ps ON pd.pasien_id = ps.id
                                                           WHERE pd.id = $pendaftaran_id"));
    $nama_pembayar = mysqli_real_escape_string($koneksi, 'RM-' . str_pad($pasien['pasien_id'],5,'0',STR_PAD_LEFT) . ' - ' . $pasien['nama_pasien']);

    $kode_transaksi = 'TRX-' . str_pad(rand(1000,9999), 4, '0', STR_PAD_LEFT);

    $query = "INSERT INTO tb_pembayaran (pendaftaran_id, kode_transaksi, total_tagihan, nama_pembayar, metode_pembayaran, no_rekening, status_transaksi, keterangan)
              VALUES ($pendaftaran_id, '$kode_transaksi', $total, '$nama_pembayar', '$metode', '$no_rek', '$status', '$ket')";

    if (mysqli_query($koneksi, $query)) {
        $id = mysqli_insert_id($koneksi);
        header("Location: cetak_kwitansi.php?id=" . $id);
        exit;
    } else {
        die("Gagal menyimpan pembayaran: " . mysqli_error($koneksi));
    }
}
?>
