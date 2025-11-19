# **README.md – Praktikum 8 PHP & MySQL (CRUD Data Barang)**

# **UNIVERSITAS PELITA BANGSA**

## **LAPORAN PRAKTIKUM 8 – PEMROGRAMAN WEB**

### **Topik: PHP & MySQL (CRUD Data Barang)**

**Nama**: LENI

**NIM**: 312410442

**Kelas**: TI.24.A5

**Program Studi**: Teknik Informatika

**Mata Kuliah**: Pemrograman Web 

---

## 📋 Deskripsi Project

Aplikasi Manajemen Data Barang adalah sistem berbasis web yang dibangun menggunakan **PHP** dan **MySQL** untuk mengelola data inventory barang. Aplikasi ini memungkinkan pengguna untuk melakukan operasi CRUD (Create, Read, Update, Delete) dengan antarmuka yang user-friendly.

## 🎯 Tujuan Praktikum

- Memahami konsep koneksi database MySQL dengan PHP menggunakan MySQLi
- Mengimplementasikan operasi CRUD (Create, Read, Update, Delete)
- Praktik pembuatan form HTML untuk input data
- Menggunakan prepared statements untuk keamanan aplikasi (SQL Injection Prevention)
- Mengimplementasikan file upload untuk menyimpan gambar barang
- Menerapkan styling CSS untuk tampilan yang profesional

## 🏗️ Struktur Project

```
lab8_php_database/
├── index.php          # Halaman utama - menampilkan daftar barang
├── tambah.php         # Form tambah data barang baru
├── ubah.php           # Form edit data barang
├── hapus.php          # Proses hapus data barang
├── koneksi.php        # File konfigurasi koneksi database
├── style.css          # Styling untuk semua halaman
├── gambar/            # Folder penyimpanan gambar barang
└── README.md          # Dokumentasi project
```

## 📊 Skema Database

### Tabel: `data_barang`

```sql
CREATE TABLE data_barang (
    id_barang INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    kategori VARCHAR(50) NOT NULL,
    harga_jual DECIMAL(10, 2) NOT NULL,
    harga_beli DECIMAL(10, 2) NOT NULL,
    stok INT NOT NULL,
    gambar VARCHAR(255)
);
```

### Kolom Tabel

<img src="kolomtable.png">

### Database

<img src="database.png">

## 📦 Fitur Utama

### 1. **Halaman Utama (index.php)**
   - Menampilkan tabel daftar semua barang
   - Kolom: Gambar, Nama, Kategori, Harga Beli, Harga Jual, Stok, Aksi
   - Tombol navigasi: Tambah Data, Ubah, Hapus

<img src="index.png">

### 2. **Tambah Data (tambah.php)**
   - Form untuk menambahkan barang baru
   - Input fields:
     - Nama Barang
     - Kategori (Komputer, Elektronik, Hand Phone)
     - Harga Jual
     - Harga Beli
     - Stok
     - File Gambar (opsional)
   - Validasi input menggunakan HTML5 dan PHP
   - Penyimpanan gambar di folder `/gambar`

<img src="tambah.png">

### 3. **Edit Data (ubah.php)**
   - Form pre-filled dengan data barang yang akan diubah
   - Kemampuan update semua field
   - Penggantian gambar lama dengan gambar baru
   - Penghapusan otomatis gambar lama saat upload gambar baru

<img src="ubah.png">

### 4. **Hapus Data (hapus.php)**
   - Menghapus data barang dari database
   - Menghapus gambar dari folder storage secara otomatis
   - Redirect ke halaman utama setelah proses

<img src="hapus.png">

## 🛠️ Teknologi yang Digunakan

| Teknologi | Versi | Fungsi |
|-----------|-------|--------|
| PHP | 7.x+ | Server-side scripting |
| MySQL | 5.7+ | Database management |
| HTML5 | - | Struktur halaman |
| CSS3 | - | Styling halaman |
| MySQLi | Built-in | Database connectivity |

## 🚀 Cara Menggunakan

### Prasyarat
- XAMPP/LAMPP sudah terinstall
- MySQL server aktif
- PHP 7.x atau lebih tinggi

### Instalasi

1. **Setup Database**
   ```sql
   CREATE DATABASE latihan1;
   USE latihan1;
   
   CREATE TABLE data_barang (
       id_barang INT AUTO_INCREMENT PRIMARY KEY,
       nama VARCHAR(100) NOT NULL,
       kategori VARCHAR(50) NOT NULL,
       harga_jual DECIMAL(10, 2) NOT NULL,
       harga_beli DECIMAL(10, 2) NOT NULL,
       stok INT NOT NULL,
       gambar VARCHAR(255)
   );
   ```

2. **Konfigurasi Koneksi** (koneksi.php)
   - Pastikan host: `localhost`
   - Username: `root`
   - Password: `` (kosong)
   - Database: `latihan1`

3. **Akses Aplikasi**
   - Buka browser: `http://localhost/lab8_php_database`
   - Halaman utama akan menampilkan daftar barang

## 💻 Penjelasan Kode Utama

### koneksi.php
```php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "latihan1";
$conn = new mysqli($host, $user, $pass, $db);
```
Membuat koneksi ke database MySQL menggunakan MySQLi dengan error handling.

### tambah.php - Prepared Statement
```php
$stmt = $conn->prepare("INSERT INTO data_barang (...) VALUES (?,?,?,?,?,?)");
$stmt->bind_param("ssddis", ...);
$stmt->execute();
```
Menggunakan prepared statements untuk mencegah SQL Injection dan validasi tipe data.

### Penanganan File Upload
```php
if(move_uploaded_file($_FILES['file_gambar']['tmp_name'], $target))
    $gambar_path = 'gambar/' . basename($target);
```
Menyimpan file gambar ke folder dengan nama yang di-timestamp untuk menghindari duplikasi.

## 🔒 Fitur Keamanan

1. **Prepared Statements** - Mencegah SQL Injection
2. **Type Binding** - Validasi tipe data otomatis
3. **File Validation** - Pemeriksaan eksistensi file sebelum penghapusan
4. **HTML Escaping** - `htmlspecialchars()` untuk output encoding
5. **Error Handling** - Try-catch dan error messages yang informatif

## 📝 Operasi CRUD

### CREATE (Tambah)
- User mengisi form di `tambah.php`
- Data divalidasi dan dikirim via POST
- Disimpan ke database dengan prepared statement

### READ (Tampilkan)
- Query SELECT menampilkan semua data di `index.php`
- Data ditampilkan dalam tabel dengan formatasi currency

### UPDATE (Ubah)
- User mengklik tombol "Ubah" di daftar barang
- Form di `ubah.php` pre-filled dengan data lama
- Perubahan data dikirim via POST dan diupdate di database

### DELETE (Hapus)
- User mengklik tombol "Hapus" dengan konfirmasi
- Data dan gambar terkait dihapus dari database dan storage
- Redirect kembali ke halaman utama
