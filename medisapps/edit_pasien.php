<?php
require_once "koneksi.php";
require_once "auth.php";

if (!isset($_GET['id'])) {
    header("Location: data_pasien.php");
    exit;
}

$id = (int) $_GET['id'];
$query = mysqli_query($koneksi, "SELECT * FROM tb_pasien WHERE id = $id");

if (mysqli_num_rows($query) === 0) {
    header("Location: data_pasien.php");
    exit;
}

$pasien = mysqli_fetch_assoc($query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Data Pasien - Apk Rumah Sakit</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="topbar">Apk Rumah Sakit</div>

    <div class="main-container">
        <div class="page-header">
            <a href="data_pasien.php" class="back-link">&larr;</a>
            <h2>Edit Data Pasien</h2>
        </div>

        <div class="form-card">
            <form action="proses_edit.php" method="POST">
                <input type="hidden" name="id" value="<?= $pasien['id'] ?>">

                <div class="form-group">
                    <label>Nama Pasien</label>
                    <input type="text" name="nama_pasien" value="<?= htmlspecialchars($pasien['nama_pasien']) ?>" required>
                </div>

                <div class="form-group">
                    <label>Jenis Kelamin</label>
                    <select name="jenis_kelamin" required
                        style="width:100%;padding:10px 12px;border:1px solid #dcdfe4;border-radius:8px;font-size:14px;">
                        <option value="Laki-laki" <?= $pasien['jenis_kelamin'] === 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                        <option value="Perempuan" <?= $pasien['jenis_kelamin'] === 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" value="<?= htmlspecialchars($pasien['email']) ?>">
                </div>

                <div class="form-group">
                    <label>No. Telp</label>
                    <input type="text" name="no_telp" value="<?= htmlspecialchars($pasien['no_telp']) ?>">
                </div>

                <div class="form-group">
                    <label>Alamat</label>
                    <input type="text" name="alamat" value="<?= htmlspecialchars($pasien['alamat']) ?>">
                </div>

                <button type="submit" class="btn-simpan">SIMPAN PERUBAHAN DATA</button>
            </form>

            <button type="button" class="btn-cetak" onclick="window.print()">CETAK DATA PASIEN INI</button>
        </div>
    </div>
</body>
</html>
