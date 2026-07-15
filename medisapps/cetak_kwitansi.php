<?php
require_once "koneksi.php";
require_once "auth.php";

if (!isset($_GET['id'])) {
    header("Location: pembayaran.php");
    exit;
}

$id = (int) $_GET['id'];
$bayar = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM tb_pembayaran WHERE id = $id"));

if (!$bayar) {
    header("Location: pembayaran.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kwitansi Pembayaran - Apk Rumah Sakit</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="topbar">Apk Rumah Sakit</div>

    <div class="main-container">
        <div class="page-header">
            <a href="pembayaran.php" class="back-link">&larr;</a>
            <h2>Kwitansi Pembayaran</h2>
        </div>

        <div class="alert-success">Pembayaran berhasil disimpan ke sistem.</div>

        <div class="detail-card">
            <div class="invoice-total-box">
                <div>
                    <div class="label">Total Tagihan Pasien</div>
                    <div class="amount">Rp <?= number_format($bayar['total_tagihan'], 0, ',', '.') ?></div>
                </div>
                <div class="trx-id">ID: #<?= htmlspecialchars($bayar['kode_transaksi']) ?></div>
            </div>

            <div class="obat-item">
                <p><b>Nama Pembayar:</b> <?= htmlspecialchars($bayar['nama_pembayar']) ?></p>
                <p><b>Metode Pembayaran:</b> <?= htmlspecialchars($bayar['metode_pembayaran']) ?></p>
                <p><b>No. Rekening/Kartu:</b> <?= htmlspecialchars($bayar['no_rekening'] ?: '-') ?></p>
                <p><b>Status Transaksi:</b> <?= htmlspecialchars($bayar['status_transaksi']) ?></p>
                <p><b>Keterangan:</b> <?= htmlspecialchars($bayar['keterangan']) ?></p>
            </div>

            <button type="button" class="btn-cetak" onclick="window.print()">CETAK KWITANSI / INVOICE</button>
            <a href="pembayaran.php" class="btn-secondary-outline">BUAT PEMBAYARAN LAIN</a>
        </div>
    </div>
</body>
</html>
