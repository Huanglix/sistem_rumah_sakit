-- ==========================================
-- SEED DATA — supaya tampilan PERSIS SAMA
-- dengan contoh di desain Figma (Ahmad Subarjo,
-- Siti Nurhaliza, Rian Hidayat, Laporan Juli 2026)
--
-- Aman untuk di-import langsung, tidak akan bentrok
-- dengan data yang sudah ada (pakai ID besar khusus
-- 90000+ yang hampir pasti belum dipakai).
--
-- Jalankan file ini SETELAH database_module2.sql
-- (lewat tab Import di phpMyAdmin, database sistem_rumah_sakit)
-- ==========================================

USE sistem_rumah_sakit;

-- Bersihkan dulu kalau sebelumnya pernah coba import (biar bisa diulang aman)
DELETE FROM tb_resep_detail WHERE resep_id IN (90024, 90012, 90025);
DELETE FROM tb_resep WHERE id IN (90024, 90012, 90025);
DELETE FROM tb_pemeriksaan WHERE id IN (90001, 90002, 90003);
DELETE FROM tb_pendaftaran WHERE id IN (90001, 90002, 90003);
DELETE FROM tb_pasien WHERE id IN (91942, 91943, 91944);
DELETE FROM tb_dokter WHERE id = 90005;
DELETE FROM tb_laporan WHERE periode = 'Juli 2026';

-- ============ PASIEN ============
INSERT INTO tb_pasien (id, nama_pasien, jenis_kelamin, email, no_telp, alamat) VALUES
(91942, 'Ahmad Subarjo', 'Laki-laki', 'ahmad.subarjo@gmail.com', '081200001942', 'Padang'),
(91943, 'Siti Nurhaliza (Anak)', 'Perempuan', 'siti.nurhaliza@gmail.com', '081200001943', 'Padang'),
(91944, 'Rian Hidayat', 'Laki-laki', 'rian.hidayat@gmail.com', '081200001944', 'Padang');

-- ============ DOKTER TAMBAHAN (dr. Siska Amelia) ============
INSERT INTO tb_dokter (id, nama_dokter, spesialisasi, email, no_telp, alamat) VALUES
(90005, 'dr. Siska Amelia', 'Anak', 'siska.amelia@gmail.com', '0000000005', 'Padang');
-- dr. Amanda (Sp. Mata) dan dr. Dian (Sp. Kulit & Kelamin) dipakai dari data awal (id 1 & 2)

-- ============ PENDAFTARAN ============
INSERT INTO tb_pendaftaran (id, no_antrean, pasien_id, poliklinik, dokter_id, jenis_pembiayaan, status) VALUES
(90001, 'A24', 91942, 'Poli Mata', 1, 'BPJS Kesehatan', 'Diperiksa'),
(90002, 'B12', 91943, 'Poli Anak', 90005, 'BPJS Kesehatan', 'Diperiksa'),
(90003, 'A25', 91944, 'Poli Kulit & Kelamin', 2, 'Umum/Mandiri', 'Menunggu');

-- ============ PEMERIKSAAN ============
INSERT INTO tb_pemeriksaan (id, pendaftaran_id, keluhan, tensi_darah, suhu_tubuh, diagnosis) VALUES
(90001, 90001, 'Mata merah dan gatal sejak 3 hari', '120/80', '36.8 C', 'Konjungtivitis + Infeksi ringan'),
(90002, 90002, 'Demam dan ruam kulit', '100/70', '38.0 C', 'Infeksi bakteri ringan'),
(90003, 90003, 'Gatal-gatal dan alergi kulit', '-', '-', 'Dermatitis alergi (menunggu pemeriksaan lanjutan)');

-- ============ RESEP (ANTREAN FARMASI) ============
INSERT INTO tb_resep (id, pemeriksaan_id, kode_antrean, status_racik, catatan_dokter) VALUES
(90024, 90001, 'A24', 'Diracik', 'Habiskan obat antibiotik, istirahat dari layar gadget.'),
(90012, 90002, 'B12', 'Siap Diambil', 'Pantau demam dan ruam. Habiskan sirup antibiotik.'),
(90025, 90003, 'A25', 'Menunggu', 'Gunakan krim tipis-tipis. Hindari paparan matahari.');

-- ============ RINCIAN OBAT ============
-- Resep A24 - Ahmad Subarjo
INSERT INTO tb_resep_detail (resep_id, nama_obat, jumlah, aturan_pakai) VALUES
(90024, 'Paracetamol 500mg', '10 Tablet (Strip)', '3 x 1 Tablet (Sesudah Makan)'),
(90024, 'Cendo Xitrol Eyedrops', '1 Botol (Mata)', 'Teteskan 4x Sehari pada Mata');

-- Resep B12 - Siti Nurhaliza (Anak)
INSERT INTO tb_resep_detail (resep_id, nama_obat, jumlah, aturan_pakai) VALUES
(90012, 'Amoxicillin Sirup 125mg/5ml', '2 Botol (Sirup)', '3 x 1.5 Sendok Takar');

-- Resep A25 - Rian Hidayat
INSERT INTO tb_resep_detail (resep_id, nama_obat, jumlah, aturan_pakai) VALUES
(90025, 'Cetirizine 10mg', '20 Tablet (Strip)', '1 x 1 Tablet (Sebelum Tidur)');

-- ============ LAPORAN BULANAN (Juli 2026) ============
INSERT INTO tb_laporan (periode, total_kunjungan, total_pendapatan, poliklinik_teraktif, jumlah_rujukan, catatan_evaluasi) VALUES
('Juli 2026', 1250, 152450000, 'Poliklinik Mata', 420, 'Kinerja bulan ini meningkat 12% dibanding bulan lalu, target pendapatan tercapai.');
