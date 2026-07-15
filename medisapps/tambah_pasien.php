<?php
require_once "koneksi.php";
require_once "auth.php";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Pasien Baru - Apk Rumah Sakit</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="topbar">Apk Rumah Sakit</div>

    <div class="main-container">
        <div class="page-header">
            <a href="data_pasien.php" class="back-link">&larr;</a>
            <h2>Data Pasien Baru</h2>
        </div>

        <div class="form-card">
            <form action="proses_tambah.php" method="POST">
                <div class="form-group">
                    <label>Nama Pasien</label>
                    <input type="text" name="nama_pasien" required>
                </div>

                <div class="form-group">
                    <label>Jenis Kelamin</label>
                    <select name="jenis_kelamin" required
                        style="width:100%;padding:10px 12px;border:1px solid #dcdfe4;border-radius:8px;font-size:14px;">
                        <option value="">-- Pilih --</option>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
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

            <button type="button" class="btn-cetak" onclick="window.print()">CETAK DATA PASIEN INI</button>
        </div>
    </div>
</body>
</html>
