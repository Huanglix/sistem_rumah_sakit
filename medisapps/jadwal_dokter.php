<?php
require_once "koneksi.php";
require_once "auth.php";

$keyword = isset($_GET['cari']) ? mysqli_real_escape_string($koneksi, $_GET['cari']) : '';

$sql = "SELECT j.*, d.nama_dokter, d.spesialisasi
        FROM tb_jadwal j
        JOIN tb_dokter d ON j.dokter_id = d.id";

if ($keyword !== '') {
    $sql .= " WHERE d.nama_dokter LIKE '%$keyword%'";
}
$sql .= " ORDER BY j.id ASC";

$query = mysqli_query($koneksi, $sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Jadwal Praktek Dokter - Apk Rumah Sakit</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="topbar">Apk Rumah Sakit</div>

    <div class="main-container">
        <div class="page-header">
            <a href="dashboard.php" class="back-link">&larr;</a>
            <h2>Jadwal Praktek Dokter</h2>
        </div>

        <form method="GET" action="">
            <input type="text" name="cari" class="search-box" placeholder="Cari nama Dokter..."
                   value="<?= htmlspecialchars($keyword) ?>" onchange="this.form.submit()">
        </form>

        <?php if (isset($_GET['msg'])): ?>
            <div class="alert-success">
                <?php
                if ($_GET['msg'] === 'tambah') echo "Jadwal baru berhasil ditambahkan.";
                if ($_GET['msg'] === 'edit') echo "Jadwal berhasil diperbarui.";
                if ($_GET['msg'] === 'hapus') echo "Jadwal berhasil dihapus.";
                ?>
            </div>
        <?php endif; ?>

        <?php while ($row = mysqli_fetch_assoc($query)): ?>
            <div class="dokter-card">
                <div class="top-row">
                    <h4><?= htmlspecialchars($row['nama_dokter']) ?></h4>
                    <span class="badge-spesialis">Sp. <?= htmlspecialchars($row['spesialisasi']) ?></span>
                </div>
                <p>
                    Hari: <?= htmlspecialchars(str_replace(',', ' & ', $row['hari_praktik'])) ?><br>
                    Jam: <?= substr($row['jam_mulai'],0,5) ?> - <?= substr($row['jam_selesai'],0,5) ?> WIB<br>
                    Kuota Pasien: <?= $row['kuota_pasien'] ?> Pasien/hari
                </p>
                <a href="edit_jadwal.php?id=<?= $row['id'] ?>" class="btn-edit-full">Edit</a>
                <a href="hapus_jadwal.php?id=<?= $row['id'] ?>" class="btn-hapus-full"
                   onclick="return confirm('Yakin ingin menghapus jadwal ini?');">Hapus</a>
            </div>
        <?php endwhile; ?>

        <a href="tambah_jadwal.php" class="btn-simpan" style="display:block; text-align:center; text-decoration:none;">+ TAMBAH JADWAL BARU</a>
    </div>
</body>
</html>
