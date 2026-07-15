<?php
require_once "koneksi.php";
require_once "auth.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pendaftaran_id = (int) $_POST['pendaftaran_id'];
    $keluhan   = mysqli_real_escape_string($koneksi, $_POST['keluhan']);
    $tensi     = mysqli_real_escape_string($koneksi, $_POST['tensi']);
    $suhu      = mysqli_real_escape_string($koneksi, $_POST['suhu']);
    $diagnosis = mysqli_real_escape_string($koneksi, $_POST['diagnosis']);
    $daftar_obat_raw = trim($_POST['daftar_obat']);
    $catatan_dokter  = mysqli_real_escape_string($koneksi, $_POST['catatan_dokter']);

    // 1) Simpan pemeriksaan
    $query = "INSERT INTO tb_pemeriksaan (pendaftaran_id, keluhan, tensi_darah, suhu_tubuh, diagnosis)
              VALUES ($pendaftaran_id, '$keluhan', '$tensi', '$suhu', '$diagnosis')";

    if (!mysqli_query($koneksi, $query)) {
        die("Gagal menyimpan pemeriksaan: " . mysqli_error($koneksi));
    }
    $pemeriksaan_id = mysqli_insert_id($koneksi);

    // 2) Update status pendaftaran jadi Diperiksa
    mysqli_query($koneksi, "UPDATE tb_pendaftaran SET status = 'Diperiksa' WHERE id = $pendaftaran_id");

    // 3) Jika ada obat, buat resep + masuk antrean farmasi
    if ($daftar_obat_raw !== '') {
        $totalAntreanFarmasi = mysqli_fetch_assoc(mysqli_query($koneksi,
            "SELECT COUNT(*) as total FROM tb_resep WHERE DATE(created_at) = CURDATE()"))['total'];
        $kodeAntrean = 'A' . str_pad($totalAntreanFarmasi + 20, 2, '0', STR_PAD_LEFT);

        $queryResep = "INSERT INTO tb_resep (pemeriksaan_id, kode_antrean, status_racik, catatan_dokter)
                       VALUES ($pemeriksaan_id, '$kodeAntrean', 'Menunggu', '$catatan_dokter')";
        mysqli_query($koneksi, $queryResep);
        $resep_id = mysqli_insert_id($koneksi);

        $baris_obat = explode("\n", $daftar_obat_raw);
        foreach ($baris_obat as $baris) {
            $baris = trim($baris);
            if ($baris === '') continue;
            $parts = array_map('trim', explode('|', $baris));
            $nama_obat = mysqli_real_escape_string($koneksi, $parts[0] ?? '');
            $jumlah    = mysqli_real_escape_string($koneksi, $parts[1] ?? '');
            $aturan    = mysqli_real_escape_string($koneksi, $parts[2] ?? '');

            if ($nama_obat !== '') {
                mysqli_query($koneksi, "INSERT INTO tb_resep_detail (resep_id, nama_obat, jumlah, aturan_pakai)
                                        VALUES ($resep_id, '$nama_obat', '$jumlah', '$aturan')");
            }
        }
    }

    header("Location: pemeriksaan.php?msg=sukses");
    exit;
}
?>
