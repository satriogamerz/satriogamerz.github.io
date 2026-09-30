# Tugas Pertemuan 2 — CRUD Sistem Informasi Manajemen Mahasiswa

**Nama:** Muhamad Satrio  
**NPM:** 2355201088  
**Kelas:** 7.4  
**Prodi:** Teknik Informatika  
**Universitas:** Universitas Muhammadiyah Bengkulu

## Tujuan
Membuat modul CRUD (Create, Read, Update, Delete) sebagai lanjutan aplikasi Sistem Informasi Manajemen Mahasiswa. Materi Pertemuan 1 menekankan desain database, koneksi, modul aplikasi, serta CRUD tabel master dan tabel yang berelasi.

## Modul CRUD
### 1. Program Studi (master)
- `prodi/index.php` — Read/list
- `prodi/tambah.php` — Create
- `prodi/edit.php` — Update
- `prodi/hapus.php` — Delete

### 2. Mahasiswa (tabel anak/berelasi)
- `mahasiswa/index.php` — Read + pencarian/filter
- `mahasiswa/tambah.php` — Create
- `mahasiswa/edit.php` — Update
- `mahasiswa/hapus.php` — Delete
- `mahasiswa/detail.php` — Detail data

Relasi: `mahasiswa.prodi_id` → `prodi.id`.

## Program Studi
Sesuai versi tugas ini tersedia 3 program studi:
1. Teknik Informatika
2. Sistem Informasi
3. Arsitektur

## Cara menjalankan
1. Jalankan Apache dan MySQL di XAMPP.
2. Letakkan folder `sistem-mahasiswa` di `C:/xampp/htdocs/`.
3. Import `database.sql` melalui phpMyAdmin.
4. Pastikan `config/database.php` sesuai database lokal.
5. Buka `http://localhost/sistem-mahasiswa/auth/login.php`.
6. Login: `admin` / `admin123`.
7. Uji menu **Program Studi** dan **Data Mahasiswa** untuk Create, Read, Update, Delete.

## Kaitan dengan materi Pertemuan 1
Pertemuan 1 menyebutkan tahapan pembuatan aplikasi: desain database, koneksi database, landing page, autentikasi, modul fitur termasuk CRUD tabel master dan tabel yang berelasi, serta laporan. Modul dalam paket ini menerapkan bagian CRUD tersebut.
