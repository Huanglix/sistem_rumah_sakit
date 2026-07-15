<?php
require_once "koneksi.php";
require_once "auth.php";

if (!isset($_GET['id'])) {
    header("Location: farmasi.php");
    exit;
}

$id = (int) $_GET['id'];

$sql = "SELECT r.*, pm.id as pemeriksaan_id, ps.nama_pasien, ps.id as pasien_id, d.nama_dokter, d.spesialisasi
        FROM tb_resep r
        JOIN tb_pemeriksaan pm ON r.pemeriksaan_id = pm.id
        JOIN tb_pendaftaran pd ON pm.pendaftaran_id = pd.id
        JOIN tb_pasien ps ON pd.pasien_id = ps.id
        JOIN tb_dokter d ON pd.dokter_id = d.id
        WHERE r.id = $id";

$result = mysqli_query($koneksi, $sql);

if (mysqli_num_rows($result) === 0) {
    header("Location: farmasi.php");
    exit;
}

$resep = mysqli_fetch_assoc($result);
$obatList = mysqli_query($koneksi, "SELECT * FROM tb_resep_detail WHERE resep_id = $id");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Resep Obat - Apk Rumah Sakit</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="topbar">Apk Rumah Sakit</div>

    <div class="main-container">
        <div class="page-header">
            <a href="farmasi.php" class="back-link">&larr;</a>
            <h2>Detail Resep Obat</h2>
        </div>

        <div class="detail-card">
            <div class="detail-header">
                <div class="farmasi-kode"><?= htmlspecialchars($resep['kode_antrean']) ?></div>
                <div>
                    <h4><?= htmlspecialchars($resep['nama_pasien']) ?></h4>
                    <p>
                        No. RM: RM-<?= str_pad($resep['pasien_id'],6,'0',STR_PAD_LEFT) ?><br>
                        Dokter: <?= htmlspecialchars($resep['nama_dokter']) ?> (Sp. <?= htmlspecialchars($resep['spesialisasi']) ?>)
                    </p>
                </div>
            </div>

            <div class="section-label">Status Antrean</div>
            <span class="status-badge
                <?php
                    $map = ['Menunggu'=>'status-menunggu','Diracik'=>'status-diracik','Siap Diambil'=>'status-siap','Selesai Diserahkan'=>'status-selesai'];
                    echo $map[$resep['status_racik']] ?? 'status-menunggu';
                ?>">
                <?= $resep['status_racik'] === 'Menunggu' ? 'Resep Belum Diproses (Menunggu)' : $resep['status_racik'] ?>
            </span>

            <div class="section-label">Rincian Obat</div>
            <?php $no = 1; while ($obat = mysqli_fetch_assoc($obatList)): ?>
                <div class="obat-item">
                    <h5><?= $no ?>. <?= htmlspecialchars($obat['nama_obat']) ?></h5>
                    <p>Jumlah Kebutuhan: <b><?= htmlspecialchars($obat['jumlah']) ?></b></p>
                    <p>Aturan Konsumsi: <b><?= htmlspecialchars($obat['aturan_pakai']) ?></b></p>
                </div>
            <?php $no++; endwhile; ?>

            <?php if (!empty($resep['catatan_dokter'])): ?>
                <div class="catatan-dokter-box">
                    Catatan Dokter:<br>"<?= htmlspecialchars($resep['catatan_dokter']) ?>"
                </div>
            <?php endif; ?>

            <?php if ($resep['status_racik'] === 'Menunggu'): ?>
                <a href="proses_update_status_resep.php?id=<?= $id ?>&status=Diracik" class="btn-status-action diracik">
                    MULAI RACIK OBAT
                </a>
            <?php elseif ($resep['status_racik'] === 'Diracik'): ?>
                <a href="proses_update_status_resep.php?id=<?= $id ?>&status=<?= urlencode('Siap Diambil') ?>" class="btn-status-action diracik">
                    SELESAI RACIK &amp; SIAP AMBIL
                </a>
            <?php elseif ($resep['status_racik'] === 'Siap Diambil'): ?>
                <a href="proses_update_status_resep.php?id=<?= $id ?>&status=<?= urlencode('Selesai Diserahkan') ?>" class="btn-status-action siap">
                    SERAHKAN OBAT KE PASIEN
                </a>
            <?php else: ?>
                <span class="btn-status-action disabled">OBAT SUDAH DISERAHKAN</span>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
