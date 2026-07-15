<?php
require_once "koneksi.php";
require_once "auth.php";

// Jika edit data laporan lama
$editData = null;
if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    $editData = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM tb_laporan WHERE id = $id"));
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Form Rekap Laporan Bulanan - Apk Rumah Sakit</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="topbar">Apk Rumah Sakit</div>

    <div class="main-container">
        <div class="page-header">
            <a href="dashboard.php" class="back-link">&larr;</a>
            <h2>Form Rekap Laporan Bulanan</h2>
        </div>

        <div class="form-card">
            <form action="proses_laporan.php" method="POST">
                <?php if ($editData): ?>
                    <input type="hidden" name="id" value="<?= $editData['id'] ?>">
                <?php endif; ?>

                <div class="form-group">
                    <label>Periode Bulan &amp; Tahun</label>
                    <input type="text" name="periode" placeholder="Contoh: Juli 2026"
                           value="<?= $editData ? htmlspecialchars($editData['periode']) : '' ?>" required>
                </div>

                <div class="form-group">
                    <label>Total Kunjungan Pasien</label>
                    <input type="number" name="total_kunjungan" placeholder="1250"
                           value="<?= $editData ? $editData['total_kunjungan'] : '' ?>" required>
                </div>

                <div class="form-group">
                    <label>Total Pendapatan (Rp)</label>
                    <input type="number" name="total_pendapatan" placeholder="152450000"
                           value="<?= $editData ? $editData['total_pendapatan'] : '' ?>" required>
                </div>

                <div class="form-group">
                    <label>Poliklinik Teraktif</label>
                    <input type="text" name="poliklinik_teraktif" placeholder="Poliklinik Mata"
                           value="<?= $editData ? htmlspecialchars($editData['poliklinik_teraktif']) : '' ?>">
                </div>

                <div class="form-group">
                    <label>Jumlah Rujukan (Poliklinik Teraktif)</label>
                    <input type="number" name="jumlah_rujukan" placeholder="420"
                           value="<?= $editData ? $editData['jumlah_rujukan'] : '' ?>">
                </div>

                <div class="form-group">
                    <label>Catatan Evaluasi Bulanan</label>
                    <textarea name="catatan_evaluasi" rows="3"><?= $editData ? htmlspecialchars($editData['catatan_evaluasi']) : '' ?></textarea>
                </div>

                <button type="submit" class="btn-simpan">SIMPAN / HASIL AKHIR</button>
            </form>
        </div>
    </div>
</body>
</html>
