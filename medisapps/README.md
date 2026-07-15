# MedisApps - Apk Rumah Sakit (Full Modul)

Versi ini sudah lengkap semua modul sesuai desain Figma:
Login, Dashboard, Data Pasien, Data Dokter, Jadwal Praktek Dokter,
Pendaftaran, Pemeriksaan Dokter, Antrean Farmasi + Detail Resep,
Pembayaran RS, dan Laporan Bulanan.

## Cara Install (Lanjutan dari database `sistem_rumah_sakit` yang sudah ada)

1. **Copy semua file di folder ini** ke `C:\xampp\htdocs\medisapps\`
   (timpa semua file lama, aman karena strukturnya sama)

2. **Import tabel tambahan**:
   - Buka `http://localhost/phpmyadmin`
   - Klik database `sistem_rumah_sakit`
   - Klik tab **Import**
   - Pilih file **`database_module2.sql`** (BUKAN database.sql yang lama, itu jangan
     di-import ulang supaya data pasien & admin yang sudah ada tidak hilang)
   - Klik **Go**

   Ini akan menambahkan tabel baru: `tb_dokter`, `tb_jadwal`, `tb_pendaftaran`,
   `tb_pemeriksaan`, `tb_resep`, `tb_resep_detail`, `tb_pembayaran`, `tb_laporan`
   — beserta beberapa data contoh dokter & jadwal.

3. **(Opsional) Import data contoh persis seperti di Figma**:
   Kalau mau tampilan Detail Resep Obat & Laporan Bulanan persis sama seperti
   contoh desain (Ahmad Subarjo, Siti Nurhaliza, Rian Hidayat, Laporan Juli 2026),
   import juga file **`seed_data_sesuai_figma.sql`** setelah `database_module2.sql`.

   Setelah itu buka:
   - `http://localhost/medisapps/farmasi.php` → klik antrean **A24**, **B12**, atau **A25**
     untuk lihat Detail Resep Obat persis seperti contoh
   - `http://localhost/medisapps/hasil_laporan.php?id=1` → untuk lihat Hasil Akhir
     Rekap Bulanan Juli 2026 persis seperti contoh

4. **Buka aplikasi**:
   ```
   http://localhost/medisapps/login.php
   ```

## Alur Kerja Sistem (Testing)

1. **Data Dokter** → tambah/lihat data dokter
2. **Jadwal Dokter** → atur hari & jam praktik tiap dokter
3. **Pendaftaran** → daftarkan pasien (pilih dari Data Pasien), pilih poli & dokter → dapat No. Antrean
4. **Pemeriksaan** → pilih pasien yang sedang antre → isi keluhan, tensi, diagnosis,
   dan **opsional isi resep obat** (format: `Nama Obat | Jumlah | Aturan Pakai`, satu baris satu obat)
   → kalau ada obat, otomatis masuk ke **Antrean Farmasi**
5. **Farmasi** → lihat antrean resep → klik salah satu → update status:
   Menunggu → Diracik → Siap Diambil → Selesai Diserahkan
6. **Pembayaran** → pilih pasien yang sudah daftar → isi tagihan → simpan → otomatis
   tampil halaman kwitansi yang bisa dicetak (print)
7. **Laporan** → isi rekap bulanan (kunjungan, pendapatan, dll) → simpan → tampil
   halaman hasil akhir dengan grafik tren mingguan sederhana, tombol Edit/Hapus,
   dan Export (print)

## Struktur File Baru
```
data_dokter.php          tambah_dokter.php        proses_tambah_dokter.php    hapus_dokter.php
jadwal_dokter.php        tambah_jadwal.php        proses_tambah_jadwal.php
edit_jadwal.php          proses_edit_jadwal.php   hapus_jadwal.php
pendaftaran.php          proses_pendaftaran.php
pemeriksaan.php          proses_pemeriksaan.php
farmasi.php              resep_detail.php         proses_update_status_resep.php
pembayaran.php           proses_pembayaran.php    cetak_kwitansi.php
laporan.php              proses_laporan.php       hasil_laporan.php    hapus_laporan.php
database_module2.sql     (tabel tambahan)
```

## Catatan
- Nomor antrean (Pendaftaran & Farmasi) dibuat otomatis sederhana berdasarkan
  urutan data hari itu (format `A01`, `A02`, dst) — bukan sistem antrean real-time.
- Chart "Tren Pasien Mingguan" di halaman Laporan dibuat otomatis dari total
  kunjungan bulanan (simulasi sederhana), bukan data mingguan asli. Kalau mau
  data mingguan asli, perlu tambah kolom minggu 1-4 di form Laporan.
- Semua tombol "Cetak" menggunakan fungsi print browser (`window.print()`) —
  belum generate PDF asli. Kalau butuh PDF asli, bisa dikembangkan lagi
  pakai library seperti `dompdf`.
