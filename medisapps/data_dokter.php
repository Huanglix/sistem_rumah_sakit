<?php
require_once "koneksi.php";
require_once "auth.php";

$query = mysqli_query($koneksi, "SELECT * FROM tb_dokter ORDER BY id ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Dokter - Apk Rumah Sakit</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="topbar">Apk Rumah Sakit</div>

    <div class="main-container">
        <div class="page-header">
            <a href="dashboard.php" class="back-link">&larr;</a>
            <h2>Data Dokter</h2>
            <a href="tambah_dokter.php" class="btn-tambah">+ Tambah</a>
        </div>

        <?php if (isset($_GET['msg'])): ?>
            <div class="alert-success">
                <?php
                if ($_GET['msg'] === 'tambah') echo "Data dokter berhasil ditambahkan.";
                if ($_GET['msg'] === 'hapus') echo "Data dokter berhasil dihapus.";
                ?>
            </div>
        <?php endif; ?>

        <?php
        $no = 1;
        while ($row = mysqli_fetch_assoc($query)):
        ?>
            <div class="dokter-card">
                <div class="top-row">
                    <h4><?= $no ?>. <?= htmlspecialchars($row['nama_dokter']) ?></h4>
                    <span class="badge-spesialis"><?= htmlspecialchars($row['spesialisasi']) ?></span>
                </div>
                <p>
                    Email: <?= htmlspecialchars($row['email']) ?><br>
                    No. Telp: <?= htmlspecialchars($row['no_telp']) ?><br>
                    Alamat: <?= htmlspecialchars($row['alamat']) ?>
                </p>
                <a href="hapus_dokter.php?id=<?= $row['id'] ?>" class="btn-hapus-full"
                   onclick="return confirm('Yakin ingin menghapus data dokter ini?');">Hapus</a>
            </div>
        <?php
            $no++;
        endwhile;
        ?>
    </div>
</body>
</html>
