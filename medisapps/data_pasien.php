<?php
require_once "koneksi.php";
require_once "auth.php";

$keyword = isset($_GET['cari']) ? mysqli_real_escape_string($koneksi, $_GET['cari']) : '';

$limit  = 5;
$page   = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page   = $page < 1 ? 1 : $page;
$offset = ($page - 1) * $limit;

$where = "";
if ($keyword !== '') {
    $where = "WHERE nama_pasien LIKE '%$keyword%'";
}

$total_result = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM tb_pasien $where");
$total_data   = mysqli_fetch_assoc($total_result)['total'];
$total_pages  = ceil($total_data / $limit);

$query = mysqli_query($koneksi, "SELECT * FROM tb_pasien $where ORDER BY id ASC LIMIT $limit OFFSET $offset");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Pasien - Apk Rumah Sakit</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="topbar">Apk Rumah Sakit</div>

    <div class="main-container">
        <div class="page-header">
            <a href="dashboard.php" class="back-link">&larr;</a>
            <h2>Data Pasien</h2>
            <a href="tambah_pasien.php" class="btn-tambah">+ Tambah</a>
        </div>

        <form method="GET" action="">
            <input type="text" name="cari" class="search-box" placeholder="Cari nama pasien..."
                   value="<?= htmlspecialchars($keyword) ?>"
                   onchange="this.form.submit()">
        </form>

        <?php if (isset($_GET['msg'])): ?>
            <div class="alert-success">
                <?php
                if ($_GET['msg'] === 'tambah') echo "Data pasien berhasil ditambahkan.";
                if ($_GET['msg'] === 'edit') echo "Data pasien berhasil diperbarui.";
                if ($_GET['msg'] === 'hapus') echo "Data pasien berhasil dihapus.";
                ?>
            </div>
        <?php endif; ?>

        <?php
        $no = $offset + 1;
        if (mysqli_num_rows($query) > 0):
            while ($row = mysqli_fetch_assoc($query)):
                $badgeClass = ($row['jenis_kelamin'] === 'Laki-laki') ? 'laki' : 'perempuan';
        ?>
            <div class="pasien-card">
                <div class="top-row">
                    <h4><?= $no ?>. <?= htmlspecialchars($row['nama_pasien']) ?></h4>
                    <span class="badge <?= $badgeClass ?>"><?= $row['jenis_kelamin'] ?></span>
                </div>
                <p>
                    Email: <?= htmlspecialchars($row['email']) ?><br>
                    No. Telp: <?= htmlspecialchars($row['no_telp']) ?><br>
                    Alamat: <?= htmlspecialchars($row['alamat']) ?>
                </p>
                <div class="action-icons">
                    <a href="edit_pasien.php?id=<?= $row['id'] ?>" class="icon-btn edit" title="Edit">&#9998;</a>
                    <a href="hapus_pasien.php?id=<?= $row['id'] ?>" class="icon-btn delete" title="Hapus"
                       onclick="return confirm('Yakin ingin menghapus data pasien ini?');">&#128465;</a>
                </div>
            </div>
        <?php
                $no++;
            endwhile;
        else:
        ?>
            <p style="text-align:center; color:#888; margin-top:30px;">Data pasien tidak ditemukan.</p>
        <?php endif; ?>

        <?php if ($total_data > 0): ?>
        <div class="pagination-box">
            <span>Showing <?= $offset + 1 ?> to <?= min($offset + $limit, $total_data) ?> of <?= $total_data ?> entries</span>
            <div class="pages">
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <?php if ($i == $page): ?>
                        <span class="active"><?= $i ?></span>
                    <?php else: ?>
                        <a href="?page=<?= $i ?>&cari=<?= urlencode($keyword) ?>"><?= $i ?></a>
                    <?php endif; ?>
                <?php endfor; ?>
                <?php if ($page < $total_pages): ?>
                    <a href="?page=<?= $page + 1 ?>&cari=<?= urlencode($keyword) ?>">Next</a>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>
