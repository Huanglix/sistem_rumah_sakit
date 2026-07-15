<?php
require_once "koneksi.php";
require_once "auth.php";

$pasienList = mysqli_query($koneksi, "SELECT id, nama_pasien FROM tb_pasien ORDER BY nama_pasien ASC");
$dokterList = mysqli_query($koneksi, "SELECT id, nama_dokter, spesialisasi FROM tb_dokter ORDER BY nama_dokter ASC");

$poliList = ['Poli Umum','Poli Mata','Poli Kulit & Kelamin','Poli Penyakit Dalam','Poli Kandungan','Poli Anak'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Form Pendaftaran - Apk Rumah Sakit</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="topbar">Apk Rumah Sakit</div>

    <div class="main-container">
        <div class="page-header">
            <a href="dashboard.php" class="back-link">&larr;</a>
            <h2>Form Pendaftaran</h2>
        </div>

        <?php if (isset($_GET['msg']) && $_GET['msg'] === 'sukses'): ?>
            <div class="alert-success">
                Pendaftaran berhasil! No. Antrean: <b><?= htmlspecialchars($_GET['antrean']) ?></b>
            </div>
        <?php endif; ?>

        <div class="form-card">
            <form action="proses_pendaftaran.php" method="POST">
                <div class="form-group">
                    <label>Pilih Rekam Medis / Cari Pasien</label>
                    <select name="pasien_id" required>
                        <option value="">-- Pilih Pasien --</option>
                        <?php while ($p = mysqli_fetch_assoc($pasienList)): ?>
                            <option value="<?= $p['id'] ?>">RM-<?= str_pad($p['id'],5,'0',STR_PAD_LEFT) ?> - <?= htmlspecialchars($p['nama_pasien']) ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Pilih Poliklinik (Tujuan)</label>
                    <select name="poliklinik" required>
                        <option value="">-- Pilih Poliklinik --</option>
                        <?php foreach ($poliList as $poli): ?>
                            <option value="<?= $poli ?>"><?= $poli ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Dokter Pemeriksa</label>
                    <select name="dokter_id" required>
                        <option value="">-- Pilih Dokter --</option>
                        <?php while ($d = mysqli_fetch_assoc($dokterList)): ?>
                            <option value="<?= $d['id'] ?>"><?= htmlspecialchars($d['nama_dokter']) ?> (Sp. <?= htmlspecialchars($d['spesialisasi']) ?>)</option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Jenis Pembiayaan</label>
                    <div class="radio-group">
                        <label><input type="radio" name="jenis_pembiayaan" value="BPJS Kesehatan" checked> BPJS Kesehatan</label>
                        <label><input type="radio" name="jenis_pembiayaan" value="Umum/Mandiri"> Umum / Mandiri</label>
                    </div>
                </div>

                <button type="submit" class="btn-simpan">SUBMIT &amp; CETAK ANTREAN</button>
            </form>
        </div>
    </div>
</body>
</html>
