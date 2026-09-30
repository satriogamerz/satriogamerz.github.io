CREATE DATABASE IF NOT EXISTS sistem_mahasiswa;
USE sistem_mahasiswa;

CREATE TABLE IF NOT EXISTS users (
 id INT AUTO_INCREMENT PRIMARY KEY,
 username VARCHAR(50) NOT NULL UNIQUE,
 password VARCHAR(255) NOT NULL,
 nama_lengkap VARCHAR(100) NOT NULL
);
INSERT IGNORE INTO users(username,password,nama_lengkap)
VALUES('admin',MD5('admin123'),'Muhamad Satrio');

CREATE TABLE IF NOT EXISTS prodi (
 id INT AUTO_INCREMENT PRIMARY KEY,
 kode_prodi VARCHAR(20) NOT NULL UNIQUE,
 nama_prodi VARCHAR(100) NOT NULL
);
INSERT IGNORE INTO prodi(id,kode_prodi,nama_prodi) VALUES
(1,'TI','Teknik Informatika'),
(2,'SI','Sistem Informasi'),
(3,'ARS','Arsitektur');
CREATE TABLE IF NOT EXISTS mahasiswa (
 id INT AUTO_INCREMENT PRIMARY KEY,
 npm VARCHAR(20) NOT NULL UNIQUE,
 nama VARCHAR(100) NOT NULL,
 jenis_kelamin ENUM('Laki-laki','Perempuan') NOT NULL,
 tempat_lahir VARCHAR(100),
 tanggal_lahir DATE,
 alamat TEXT,
 no_hp VARCHAR(20),
 email VARCHAR(100),
 prodi_id INT NOT NULL,
 angkatan YEAR NOT NULL,
 FOREIGN KEY(prodi_id) REFERENCES prodi(id) ON DELETE RESTRICT ON UPDATE CASCADE
);
