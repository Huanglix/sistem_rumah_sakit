-- ==========================================
-- DATABASE: sistem_rumah_sakit
-- Import file ini lewat phpMyAdmin (XAMPP)
-- ==========================================

CREATE DATABASE IF NOT EXISTS sistem_rumah_sakit;
USE sistem_rumah_sakit;

-- Tabel Login Admin
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Password default: admin123 (sudah di-hash bcrypt)
INSERT INTO users (username, password) VALUES
('admin', '$2y$10$qhEIxBjfg55GtC0wuXl.kulZOMI.T0v7ITsmiPLkJA5i8HXcKxU5.');
-- Hash di atas = password("admin123")

-- Tabel Data Pasien
CREATE TABLE IF NOT EXISTS tb_pasien (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_pasien VARCHAR(100) NOT NULL,
    jenis_kelamin ENUM('Laki-laki','Perempuan') NOT NULL,
    email VARCHAR(100),
    no_telp VARCHAR(20),
    alamat VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Contoh data dummy sesuai tampilan Figma
INSERT INTO tb_pasien (nama_pasien, jenis_kelamin, email, no_telp, alamat) VALUES
('Pasien 1', 'Laki-laki', 'pasien1@gmail.com', '0000000001', 'Padang'),
('Pasien 2', 'Laki-laki', 'pasien2@gmail.com', '0000000002', 'Padang'),
('Pasien 3', 'Laki-laki', 'pasien3@gmail.com', '0000000003', 'Jakarta'),
('Pasien 4', 'Laki-laki', 'pasien4@gmail.com', '0000000004', 'Jambi'),
('Pasien 5', 'Perempuan', 'pasien5@gmail.com', '0000000005', 'Medan');
