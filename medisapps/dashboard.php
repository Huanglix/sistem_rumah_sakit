<?php
require_once "koneksi.php";
require_once "auth.php";

$total_pasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM tb_pasien"))['total'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Apk Rumah Sakit</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="topbar">Apk Rumah Sakit</div>

    <div class="main-container">
        <p class="greeting">Halo, Admin</p>
        <h2 class="dashboard-title">Dashboard Utama</h2>

        <div class="menu-grid">
            <a href="data_pasien.php" class="menu-card">
                <h3>Data Pasien</h3>
                <span><?= $total_pasien ?> Total &rarr;</span>
            </a>

            <a href="data_dokter.php" class="menu-card">
                <h3>Data Dokter</h3>
                <span class="blue">Kelola Dokter &rarr;</span>
            </a>

            <a href="jadwal_dokter.php" class="menu-card">
                <h3>Jadwal Dokter</h3>
                <span class="gray">Lihat Shift Terkini</span>
            </a>

            <a href="pendaftaran.php" class="menu-card">
                <h3>Pendaftaran</h3>
                <span class="gray">Pasien Baru/Lama</span>
            </a>

            <a href="pemeriksaan.php" class="menu-card">
                <h3>Pemeriksaan</h3>
                <span class="gray">Catatan Medis</span>
            </a>

            <a href="farmasi.php" class="menu-card">
                <h3>Farmasi</h3>
                <span class="orange">Antrean Obat &rarr;</span>
            </a>

            <a href="pembayaran.php" class="menu-card">
                <h3>Pembayaran</h3>
                <span class="gray">Kasir &amp; Faktur</span>
            </a>

            <a href="laporan.php" class="menu-card">
                <h3>Laporan</h3>
                <span class="gray">Rekap Bulanan</span>
            </a>

            <a href="logout.php" class="logout-btn">Keluar Sistem (Logout)</a>
        </div>
    </div>

    <a href="tambah_pasien.php" class="fab-add" title="Tambah Pasien">+</a>
</body>
</html>
