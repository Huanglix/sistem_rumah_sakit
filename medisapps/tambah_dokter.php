<?php
require_once "koneksi.php";
require_once "auth.php";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Data Dokter - Apk Rumah Sakit</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="topbar">Apk Rumah Sakit</div>

    <div class="main-container">
        <div class="page-header">
            <a href="data_dokter.php" class="back-link">&larr;</a>
            <h2>Tambah Data Dokter</h2>
        </div>

        <div class="form-card">
            <form action="proses_tambah_dokter.php" method="POST">
                <div class="form-group">
                    <label>Nama Dokter</label>
                    <input type="text" name="nama_dokter" required>
                </div>

                <div class="form-group">
                    <label>Spesialisasi</label>
                    <input type="text" name="spesialisasi" placeholder="Contoh: Mata, Kulit & Kelamin" required>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email">
                </div>

                <div class="form-group">
                    <label>No. Telp</label>
                    <input type="text" name="no_telp">
                </div>

                <div class="form-group">
                    <label>Alamat</label>
                    <input type="text" name="alamat">
                </div>

                <button type="submit" class="btn-simpan">SIMPAN DATA</button>
            </form>

            <button type="button" class="btn-cetak" onclick="window.print()">CETAK DATA DOKTER</button>
        </div>
    </div>
</body>
</html>
