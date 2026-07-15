<?php
require_once "koneksi.php";
require_once "auth.php";

$keyword = isset($_GET['cari']) ? mysqli_real_escape_string($koneksi, $_GET['cari']) : '';

$sql = "SELECT r.id, r.kode_antrean, r.status_racik, ps.nama_pasien, d.nama_dokter,
               (SELECT COUNT(*) FROM tb_resep_detail rd WHERE rd.resep_id = r.id) as jumlah_obat
        FROM tb_resep r
        JOIN tb_pemeriksaan pm ON r.pemeriksaan_id = pm.id
        JOIN tb_pendaftaran pd ON pm.pendaftaran_id = pd.id
        JOIN tb_pasien ps ON pd.pasien_id = ps.id
        JOIN tb_dokter d ON pd.dokter_id = d.id
        WHERE r.status_racik != 'Selesai Diserahkan'";

if ($keyword !== '') {
    $sql .= " AND (ps.nama_pasien LIKE '%$keyword%' OR r.kode_antrean LIKE '%$keyword%')";
}
$sql .= " ORDER BY r.id ASC";

$query = mysqli_query($koneksi, $sql);
$totalHariIni = mysqli_fetch_assoc(mysqli_query($koneksi,
    "SELECT COUNT(*) as total FROM tb_resep WHERE status_racik != 'Selesai Diserahkan'"))['total'];
$totalSelesai = mysqli_fetch_assoc(mysqli_query($koneksi,
    "SELECT COUNT(*) as total FROM tb_resep WHERE status_racik = 'Selesai Diserahkan' AND DATE(created_at) = CURDATE()"))['total'];

function badgeStatus($status) {
    $map = [
        'Menunggu' => 'status-menunggu',
        'Diracik' => 'status-diracik',
        'Siap Diambil' => 'status-siap',
        'Selesai Diserahkan' => 'status-selesai',
    ];
    $class = $map[$status] ?? 'status-menunggu';
    return "<span class='status-badge $class'>$status</span>";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Antrean Farmasi - Apk Rumah Sakit</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="topbar">Apk Rumah Sakit</div>

    <div class="main-container">
        <div class="page-header">
            <a href="dashboard.php" class="back-link">&larr;</a>
            <h2>Antrean Farmasi</h2>
            <span class="badge-mini"><?= $totalHariIni ?> Antrean</span>
        </div>

        <form method="GET" action="">
            <input type="text" name="cari" class="search-box" placeholder="Cari nama pasien atau No. RM..."
                   value="<?= htmlspecialchars($keyword) ?>" onchange="this.form.submit()">
        </form>

        <?php if (mysqli_num_rows($query) === 0): ?>
            <p style="text-align:center; color:#888; margin-top:20px;">Tidak ada antrean farmasi saat ini.</p>
        <?php endif; ?>

        <?php while ($row = mysqli_fetch_assoc($query)): ?>
            <a href="resep_detail.php?id=<?= $row['id'] ?>" class="farmasi-card">
                <div class="farmasi-kode"><?= htmlspecialchars($row['kode_antrean']) ?></div>
                <div class="farmasi-info">
                    <h4><?= htmlspecialchars($row['nama_pasien']) ?></h4>
                    <p><?= htmlspecialchars($row['nama_dokter']) ?> &bull; <?= $row['jumlah_obat'] ?> Obat</p>
                </div>
                <?= badgeStatus($row['status_racik']) ?>
            </a>
        <?php endwhile; ?>

        <div class="farmasi-footer-note">
            Efisiensi Farmasi Hari Ini<br>
            &check; <?= $totalSelesai ?> Resep Selesai Penyerahan
        </div>
    </div>
</body>
</html>
