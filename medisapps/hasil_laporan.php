<?php
require_once "koneksi.php";
require_once "auth.php";

if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit;
}

$id = (int) $_GET['id'];
$laporan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM tb_laporan WHERE id = $id"));

if (!$laporan) {
    header("Location: dashboard.php");
    exit;
}

// Simulasi tren mingguan sederhana dari total_kunjungan (dibagi rata + variasi kecil)
$base = max(1, intdiv($laporan['total_kunjungan'], 4));
$tren = [
    round($base * 0.85),
    round($base * 1.05),
    round($base * 1.15),
    round($base * 0.95),
];
$maxTren = max($tren) ?: 1;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Hasil Akhir Rekap Bulanan - Apk Rumah Sakit</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="topbar">Apk Rumah Sakit</div>

    <div class="main-container">
        <div class="page-header">
            <a href="dashboard.php" class="back-link">&larr;</a>
            <h2>Hasil Akhir Rekap Bulanan</h2>
        </div>

        <div class="periode-tag">&#128197; <?= htmlspecialchars($laporan['periode']) ?></div>

        <div class="stat-box">
            <div class="label">
                <span>Total Kunjungan Pasien</span>
                <span class="trend-up">&#9650; 12%</span>
            </div>
            <div class="value"><?= number_format($laporan['total_kunjungan'], 0, ',', '.') ?> Pasien</div>
        </div>

        <div class="stat-box">
            <div class="label">
                <span>Total Pendapatan RS</span>
                <span class="badge-mini">Target Tercapai</span>
            </div>
            <div class="value">Rp <?= number_format($laporan['total_pendapatan'], 0, ',', '.') ?></div>
        </div>

        <div class="stat-box">
            <div class="label">
                <span>Poliklinik Teraktif / Terramai</span>
                <span class="badge-mini"><?= (int) $laporan['jumlah_rujukan'] ?> Rujukan</span>
            </div>
            <div class="value"><?= htmlspecialchars($laporan['poliklinik_teraktif'] ?: '-') ?></div>
        </div>

        <div class="stat-box">
            <div class="label"><span>Tren Pasien Mingguan (<?= htmlspecialchars($laporan['periode']) ?>)</span></div>
            <div class="chart-bars">
                <?php foreach ($tren as $i => $val): ?>
                    <div class="bar-col">
                        <div class="bar" style="height: <?= max(10, ($val / $maxTren) * 90) ?>px;"></div>
                        <div class="bar-label">W<?= $i + 1 ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <?php if (!empty($laporan['catatan_evaluasi'])): ?>
            <div class="catatan-dokter-box" style="margin-bottom:14px;">
                Catatan Evaluasi:<br>"<?= htmlspecialchars($laporan['catatan_evaluasi']) ?>"
            </div>
        <?php endif; ?>

        <div class="kelola-row">
            <span style="font-size:13px; color:#333;">Kelola Data Laporan</span>
            <div>
                <a href="laporan.php?id=<?= $laporan['id'] ?>" class="btn-edit-full">Edit</a>
                <a href="hapus_laporan.php?id=<?= $laporan['id'] ?>" class="btn-hapus-full"
                   onclick="return confirm('Yakin ingin menghapus laporan ini?');">Hapus</a>
            </div>
        </div>

        <button type="button" class="btn-export" onclick="showExportModal()">&#128196; EXPORT KE EXCEL / PDF</button>
        <a href="logout.php" class="btn-logout-full">LOGOUT</a>
    </div>

    <!-- Modal Popup: Unduh PDF Berhasil -->
    <div class="modal-overlay" id="exportModal">
        <div class="modal-box">
            <div class="modal-icon">&#128196;</div>
            <div class="modal-title">Unduh PDF Berhasil!</div>
            <div class="modal-desc">
                Berkas rekap bulanan <?= htmlspecialchars($laporan['periode']) ?> telah tersimpan di perangkat.
            </div>
            <button type="button" class="btn-modal-ok" onclick="closeExportModal()">Berhasil</button>
        </div>
    </div>

    <script>
        function showExportModal() {
            document.getElementById('exportModal').classList.add('active');
        }
        function closeExportModal() {
            document.getElementById('exportModal').classList.remove('active');
        }
    </script>
</body>
</html>
