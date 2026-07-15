<?php
require_once "koneksi.php";
require_once "auth.php";

$sql = "SELECT pd.id, ps.nama_pasien, ps.id as pasien_id
        FROM tb_pendaftaran pd
        JOIN tb_pasien ps ON pd.pasien_id = ps.id
        ORDER BY pd.id DESC";
$pendaftaranList = mysqli_query($koneksi, $sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Form Pembayaran RS - Apk Rumah Sakit</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="topbar">Apk Rumah Sakit</div>

    <div class="main-container">
        <div class="page-header">
            <a href="dashboard.php" class="back-link">&larr;</a>
            <h2>Form Pembayaran RS</h2>
        </div>

        <div class="form-card">
            <form action="proses_pembayaran.php" method="POST">
                <div class="form-group">
                    <label>Nama Pembayar / Pasien</label>
                    <select name="pendaftaran_id" required>
                        <option value="">-- Pilih Pasien --</option>
                        <?php while ($p = mysqli_fetch_assoc($pendaftaranList)): ?>
                            <option value="<?= $p['id'] ?>">RM-<?= str_pad($p['pasien_id'],5,'0',STR_PAD_LEFT) ?> - <?= htmlspecialchars($p['nama_pasien']) ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Total Tagihan (Rp)</label>
                    <input type="number" name="total_tagihan" placeholder="245000" required>
                </div>

                <div class="form-group">
                    <label>Pilih Opsi Metode Pembayaran</label>
                    <select name="metode_pembayaran" required>
                        <option value="Tunai / Cash">Tunai / Cash</option>
                        <option value="Transfer Bank">Transfer Bank</option>
                        <option value="BPJS Kesehatan">BPJS Kesehatan</option>
                        <option value="Kartu Debit/Kredit">Kartu Debit / Kredit</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Nomor Rekening / No. Kartu BPJS / Asuransi (Jika non-tunai)</label>
                    <input type="text" name="no_rekening" placeholder="- (Pembayaran Tunai)">
                </div>

                <div class="form-group">
                    <label>Status Transaksi</label>
                    <select name="status_transaksi" required>
                        <option value="Lunas">Lunas</option>
                        <option value="Belum Lunas">Belum Lunas</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Keterangan Tambahan</label>
                    <input type="text" name="keterangan" placeholder="Contoh: Poli Penyakit Dalam + Obat Farmasi">
                </div>

                <button type="submit" class="btn-simpan">PROSES &amp; SIMPAN PEMBAYARAN</button>
            </form>
        </div>
    </div>
</body>
</html>
