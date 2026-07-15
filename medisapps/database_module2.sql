-- ==========================================
-- TABEL TAMBAHAN untuk sistem_rumah_sakit
-- Jalankan file ini SETELAH database.sql yang lama
-- (lewat tab SQL di phpMyAdmin, database sistem_rumah_sakit)
-- ==========================================

USE sistem_rumah_sakit;

-- ============ DATA DOKTER ============
CREATE TABLE IF NOT EXISTS tb_dokter (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_dokter VARCHAR(100) NOT NULL,
    spesialisasi VARCHAR(100),
    email VARCHAR(100),
    no_telp VARCHAR(20),
    alamat VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO tb_dokter (nama_dokter, spesialisasi, email, no_telp, alamat) VALUES
('dr. Amanda', 'Mata', 'dokter1@gmail.com', '0000000001', 'Padang'),
('dr. Dian', 'Kulit & Kelamin', 'dokter2@gmail.com', '0000000002', 'Padang'),
('dr. Fikri', 'Penyakit Dalam', 'dokter3@gmail.com', '0000000003', 'Padang'),
('dr. Chintia', 'Kandungan', 'dokter4@gmail.com', '0000000004', 'Padang');

-- ============ JADWAL PRAKTEK DOKTER ============
CREATE TABLE IF NOT EXISTS tb_jadwal (
    id INT AUTO_INCREMENT PRIMARY KEY,
    dokter_id INT NOT NULL,
    hari_praktik VARCHAR(100) NOT NULL,      -- contoh: "Senin,Rabu"
    jam_mulai TIME NOT NULL,
    jam_selesai TIME NOT NULL,
    kuota_pasien INT DEFAULT 20,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (dokter_id) REFERENCES tb_dokter(id) ON DELETE CASCADE
);

INSERT INTO tb_jadwal (dokter_id, hari_praktik, jam_mulai, jam_selesai, kuota_pasien) VALUES
(1, 'Senin,Rabu', '08:00:00', '12:00:00', 30),
(2, 'Selasa,Kamis', '13:00:00', '16:00:00', 20),
(3, 'Senin,Jumat', '09:00:00', '14:00:00', 25);

-- ============ PENDAFTARAN PASIEN ============
CREATE TABLE IF NOT EXISTS tb_pendaftaran (
    id INT AUTO_INCREMENT PRIMARY KEY,
    no_antrean VARCHAR(20) NOT NULL,
    pasien_id INT NOT NULL,
    poliklinik VARCHAR(100) NOT NULL,
    dokter_id INT NOT NULL,
    jenis_pembiayaan ENUM('BPJS Kesehatan','Umum/Mandiri') NOT NULL,
    status ENUM('Menunggu','Diperiksa','Selesai') DEFAULT 'Menunggu',
    tanggal_daftar DATE DEFAULT (CURRENT_DATE),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (pasien_id) REFERENCES tb_pasien(id) ON DELETE CASCADE,
    FOREIGN KEY (dokter_id) REFERENCES tb_dokter(id) ON DELETE CASCADE
);

-- ============ PEMERIKSAAN / REKAM MEDIS ============
CREATE TABLE IF NOT EXISTS tb_pemeriksaan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pendaftaran_id INT NOT NULL,
    keluhan TEXT,
    tensi_darah VARCHAR(20),
    suhu_tubuh VARCHAR(20),
    diagnosis TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (pendaftaran_id) REFERENCES tb_pendaftaran(id) ON DELETE CASCADE
);

-- ============ RESEP OBAT (ANTREAN FARMASI) ============
CREATE TABLE IF NOT EXISTS tb_resep (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pemeriksaan_id INT NOT NULL,
    kode_antrean VARCHAR(20) NOT NULL,
    status_racik ENUM('Menunggu','Diracik','Siap Diambil','Selesai Diserahkan') DEFAULT 'Menunggu',
    catatan_dokter TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (pemeriksaan_id) REFERENCES tb_pemeriksaan(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS tb_resep_detail (
    id INT AUTO_INCREMENT PRIMARY KEY,
    resep_id INT NOT NULL,
    nama_obat VARCHAR(150) NOT NULL,
    jumlah VARCHAR(50),
    aturan_pakai VARCHAR(150),
    FOREIGN KEY (resep_id) REFERENCES tb_resep(id) ON DELETE CASCADE
);

-- ============ PEMBAYARAN ============
CREATE TABLE IF NOT EXISTS tb_pembayaran (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pendaftaran_id INT NOT NULL,
    kode_transaksi VARCHAR(30) NOT NULL,
    total_tagihan DECIMAL(12,2) NOT NULL,
    nama_pembayar VARCHAR(100),
    metode_pembayaran VARCHAR(50),
    no_rekening VARCHAR(50),
    status_transaksi ENUM('Lunas','Belum Lunas') DEFAULT 'Lunas',
    keterangan VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (pendaftaran_id) REFERENCES tb_pendaftaran(id) ON DELETE CASCADE
);

-- ============ LAPORAN BULANAN ============
CREATE TABLE IF NOT EXISTS tb_laporan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    periode VARCHAR(30) NOT NULL,
    total_kunjungan INT DEFAULT 0,
    total_pendapatan DECIMAL(14,2) DEFAULT 0,
    poliklinik_teraktif VARCHAR(100),
    jumlah_rujukan INT DEFAULT 0,
    catatan_evaluasi TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
