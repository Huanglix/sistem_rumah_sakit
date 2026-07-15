<?php
require_once "koneksi.php";
require_once "auth.php";

// Ambil daftar pasien yang sedang menunggu pemeriksaan
$antreanList = mysqli_query($koneksi, "SELECT p.id, p.no_antrean, ps.nama_pasien, d.nama_dokter
                                        FROM tb_pendaftaran p
                                        JOIN tb_pasien ps ON p.pasien_id = ps.id
                                        JOIN tb_dokter d ON p.dokter_id = d.id
                                        WHERE p.status = 'Menunggu'
                                        ORDER BY p.id ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Input Pemeriksaan Dokter - Apk Rumah Sakit</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="topbar">Apk Rumah Sakit</div>

    <div class="main-container">
        <div class="page-header">
            <a href="dashboard.php" class="back-link">&larr;</a>
            <h2>Input Pemeriksaan Dokter</h2>
        </div>

        <?php if (isset($_GET['msg']) && $_GET['msg'] === 'sukses'): ?>
            <div class="alert-success">Rekam medis berhasil di simpan ke sistem.</div>
        <?php endif; ?>

        <div class="form-card">
            <form action="proses_pemeriksaan.php" method="POST">
                <div class="form-group">
                    <label>Pilih Antrean Pasien</label>
                    <select name="pendaftaran_id" required>
                        <option value="">-- Pilih Pasien --</option>
                        <?php while ($a = mysqli_fetch_assoc($antreanList)): ?>
                            <option value="<?= $a['id'] ?>">
                                <?= $a['no_antrean'] ?> - <?= htmlspecialchars($a['nama_pasien']) ?> (<?= htmlspecialchars($a['nama_dokter']) ?>)
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Keluhan Pasien (keluhan)</label>
                    <textarea name="keluhan" rows="2" placeholder="Contoh: Demam tinggi 3 hari dan batuk" required></textarea>
                </div>

                <div class="form-group two-col">
                    <div class="form-group">
                        <label>Tensi Darah</label>
                        <input type="text" name="tensi" placeholder="110/70" required>
                    </div>
                    <div class="form-group">
                        <label>Suhu Tubuh</label>
                        <input type="text" name="suhu" placeholder="38.5 C" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Hasil Diagnosis (diagnosis)</label>
                    <textarea name="diagnosis" rows="2" placeholder="Contoh: Influenza / Demam Ringan" required></textarea>
                </div>

                <div class="section-label" style="margin-top:20px;">Resep Obat (opsional)</div>
                <p style="font-size:12px; color:#888; margin-bottom:10px;">
                    Isi satu obat per baris dengan format: <b>Nama Obat | Jumlah | Aturan Pakai</b><br>
                    Contoh: <i>Paracetamol 500mg | 10 Tablet (Strip) | 3x1 Tablet (Sesudah Makan)</i>
                </p>
                <div class="form-group">
                    <textarea name="daftar_obat" rows="4" placeholder="Paracetamol 500mg | 10 Tablet (Strip) | 3x1 Tablet (Sesudah Makan)"></textarea>
                </div>

                <div class="form-group">
                    <label>Catatan Dokter untuk Farmasi (opsional)</label>
                    <textarea name="catatan_dokter" rows="2" placeholder="Contoh: Habiskan obat antibiotik, istirahat dari layar gadget."></textarea>
                </div>

                <button type="submit" class="btn-simpan">SIMPAN REKAM MEDIS</button>
            </form>
        </div>
    </div>
</body>
</html>
