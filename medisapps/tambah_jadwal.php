<?php
require_once "koneksi.php";
require_once "auth.php";

$dokterList = mysqli_query($koneksi, "SELECT id, nama_dokter, spesialisasi FROM tb_dokter ORDER BY nama_dokter ASC");
$hariList = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Jadwal - Apk Rumah Sakit</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="topbar">Apk Rumah Sakit</div>

    <div class="main-container">
        <div class="page-header">
            <a href="jadwal_dokter.php" class="back-link">&larr;</a>
            <h2>Tambah Jadwal Dokter</h2>
        </div>

        <div class="form-card">
            <form action="proses_tambah_jadwal.php" method="POST">
                <div class="form-group">
                    <label>Nama Dokter</label>
                    <select name="dokter_id" required>
                        <option value="">-- Pilih Dokter --</option>
                        <?php while ($d = mysqli_fetch_assoc($dokterList)): ?>
                            <option value="<?= $d['id'] ?>"><?= htmlspecialchars($d['nama_dokter']) ?> (Sp. <?= htmlspecialchars($d['spesialisasi']) ?>)</option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Hari Praktik</label>
                    <div class="checkbox-group">
                        <?php foreach ($hariList as $h): ?>
                            <label><input type="checkbox" name="hari[]" value="<?= $h ?>"> <?= $h ?></label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="form-group two-col">
                    <div class="form-group">
                        <label>Jam Mulai</label>
                        <input type="time" name="jam_mulai" required>
                    </div>
                    <div class="form-group">
                        <label>Jam Selesai</label>
                        <input type="time" name="jam_selesai" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Maksimal Kuota Pasien</label>
                    <input type="number" name="kuota_pasien" value="20" min="1" required>
                </div>

                <button type="submit" class="btn-simpan">SIMPAN JADWAL</button>
            </form>
        </div>
    </div>
</body>
</html>
