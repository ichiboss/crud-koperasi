-- Buat Database
CREATE DATABASE IF NOT EXISTS db_koperasi;
USE db_koperasi;

-- Tabel Anggota
CREATE TABLE IF NOT EXISTS anggota (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nomor_anggota VARCHAR(20) UNIQUE NOT NULL,
    nama_lengkap VARCHAR(100) NOT NULL,
    nik VARCHAR(20) UNIQUE NOT NULL,
    alamat TEXT,
    telepon VARCHAR(20),
    email VARCHAR(100),
    status ENUM('Aktif', 'Non-Aktif') DEFAULT 'Aktif',
    tanggal_daftar TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel Users (Admin)
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    nama_admin VARCHAR(100),
    last_login TIMESTAMP NULL
);

-- Insert Admin Default (Username: admin, Password: admin123)
INSERT INTO users (username, password, nama_admin) 
VALUES ('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator Utama')
ON DUPLICATE KEY UPDATE username=username;
