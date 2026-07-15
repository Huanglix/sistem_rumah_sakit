<?php
require_once "koneksi.php";
require_once "auth.php";

if (!isset($_GET['id'])) {
    header("Location: jadwal_dokter.php");
    exit;
}

$id = (int) $_GET['id'];
$query = mysqli_query($koneksi, "SELECT j.*, d.nama_dokter, d.spesialisasi
                                  FROM tb_jadwal j
                                  JOIN tb_dokter d ON j.dokter_id = d.id
                                  WHERE j.id = $id");

if (mysqli_num_rows($query) === 0) {
    header("Location: jadwal_dokter.php");
    exit;
}

$jadwal = mysqli_fetch_assoc($query);
$hariAktif = explode(',', $jadwal['hari_praktik']);
$hariList = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Jadwal Dokter - Apk Rumah Sakit</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="topbar">Apk Rumah Sakit</div>

    <div class="main-container">
        <div class="page-header">
            <a href="jadwal_dokter.php" class="back-link">&larr;</a>
            <h2>Edit Jadwal Dokter</h2>
        </div>

        <div class="form-card">
            <form action="proses_edit_jadwal.php" method="POST">
                <input type="hidden" name="id" value="<?= $jadwal['id'] ?>">

                <div class="form-group">
                    <label>Nama Dokter</label>
                    <input type="text" value="<?= htmlspecialchars($jadwal['nama_dokter']) ?> (Sp. <?= htmlspecialchars($jadwal['spesialisasi']) ?>)" disabled
                           style="background:#f2f2f2;">
                </div>

                <div class="form-group">
                    <label>Ubah Hari Praktik</label>
                    <div class="checkbox-group">
                        <?php foreach ($hariList as $h): ?>
                            <label>
                                <input type="checkbox" name="hari[]" value="<?= $h ?>"
                                    <?= in_array($h, $hariAktif) ? 'checked' : '' ?>> <?= $h ?>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="form-group two-col">
                    <div class="form-group">
                        <label>Jam Praktik (mulai)</label>
                        <input type="time" name="jam_mulai" value="<?= substr($jadwal['jam_mulai'],0,5) ?>" required>
                    </div>
                    <div class="form-group">
                        <label>s/d (selesai)</label>
                        <input type="time" name="jam_selesai" value="<?= substr($jadwal['jam_selesai'],0,5) ?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Maksimal Kuota Pasien</label>
                    <input type="number" name="kuota_pasien" value="<?= $jadwal['kuota_pasien'] ?>" min="1" required>
                </div>

                <button type="submit" class="btn-simpan">SIMPAN PERUBAHAN</button>
            </form>
        </div>
    </div>
</body>
</html>
