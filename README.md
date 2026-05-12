# 🛒 YOOOW STORE - Sistem Pemesanan Barang Online

## 📌 Deskripsi Aplikasi

YOOOW STORE adalah aplikasi web berbasis **PHP dan MySQL** yang digunakan untuk melakukan pemesanan barang secara online. Aplikasi ini menyediakan fitur pengelolaan data barang, pemesanan, serta dashboard admin dengan tampilan modern menggunakan Bootstrap.

Aplikasi ini juga menggunakan kombinasi **database MySQL** dan **penyimpanan JSON** untuk mengelola data pesanan secara fleksibel. Sistem dilengkapi dengan fitur login, upload gambar, serta notifikasi interaktif menggunakan SweetAlert.

---

## 🎯 Tujuan Aplikasi

Tujuan dibuatnya aplikasi ini adalah:

* Mempermudah proses pemesanan barang secara online
* Mengelola data barang dan pesanan secara terstruktur
* Mengurangi kesalahan pencatatan manual
* Memberikan pengalaman pengguna yang lebih mudah dan cepat
* Sebagai media pembelajaran dasar:

  * CRUD (Create, Read, Update, Delete)
  * Koneksi database MySQL
  * Penggunaan PHP Native
  * Integrasi JSON sebagai penyimpanan data tambahan
* Menjadi contoh sederhana sistem informasi penjualan online

---

## ▶️ Cara Penggunaan

### 1. Persiapan

* Install **XAMPP / Laragon**
* Jalankan **Apache & MySQL**

### 2. Import Database

* Buka phpMyAdmin
* Buat database dengan nama:

```
pemesanan_db
```

* Import file:

```
pemesanan_barang.sql
```

### 3. Konfigurasi Koneksi

Pastikan file koneksi sudah sesuai:

📄 `config/koneksi.php` 

* Host: localhost
* User: root
* Password: (kosong)
* Database: pemesanan_db

---

### 4. Jalankan Aplikasi

* Simpan project di folder:

```
htdocs/
```

* Akses di browser:

```
http://localhost/nama_folder_project
```

---

### 5. Login Admin

Gunakan akun berikut:

```
Username: admin
Password: admin
```

(*Password sudah di-hash MD5 di database*)

---

## 📂 Struktur Folder

```
project/
│
├── assets/
│   ├── css/           → File CSS tampilan :contentReference[oaicite:1]{index=1}
│   └── images/        → Logo aplikasi
│
├── config/
│   ├── koneksi.php        → Koneksi database MySQL :contentReference[oaicite:2]{index=2}
│   └── koneksi_json.php   → Koneksi data JSON :contentReference[oaicite:3]{index=3}
│
├── data/
│   └── data.json     → Penyimpanan data pesanan :contentReference[oaicite:4]{index=4}
│
├── uploads/
│   └── (gambar barang)
│
├── halaman utama:
│   ├── index.php           → Halaman login :contentReference[oaicite:5]{index=5}
│   ├── dashboard.php       → Dashboard admin :contentReference[oaicite:6]{index=6}
│   ├── barang.php          → Data barang :contentReference[oaicite:7]{index=7}
│   ├── tambah_barang.php   → Tambah barang
│   ├── simpan_barang.php   → Proses simpan barang :contentReference[oaicite:8]{index=8}
│   ├── hapus_barang.php    → Hapus barang :contentReference[oaicite:9]{index=9}
│
│   ├── pemesanan.php       → Form pemesanan :contentReference[oaicite:10]{index=10}
│   ├── proses.php          → Proses pemesanan :contentReference[oaicite:11]{index=11}
│   ├── data_pesanan.php    → Data pesanan dari database :contentReference[oaicite:12]{index=12}
│   ├── data_pemesanan.php  → Data dari JSON :contentReference[oaicite:13]{index=13}
│
│   └── logout.php          → Logout sistem :contentReference[oaicite:14]{index=14}
│
└── database/
    └── pemesanan_barang.sql :contentReference[oaicite:15]{index=15}
```

---

## 🚀 Fitur Aplikasi

* ✅ Login Admin
* ✅ Dashboard dengan grafik (Chart.js)
* ✅ CRUD Data Barang
* ✅ Upload Gambar Barang
* ✅ Pencarian Barang
* ✅ Pemesanan Barang Online
* ✅ Perhitungan Otomatis Total Biaya
* ✅ Penyimpanan Data (MySQL + JSON)
* ✅ Notifikasi Interaktif (SweetAlert)
* ✅ Dark Mode

---

## ⚠️ Catatan

* Pastikan folder `uploads/` memiliki permission write
* Pastikan file `data.json` bisa ditulis (writeable)
* Gunakan PHP versi 7 ke atas

---

## 👨‍💻 Developer

Project ini dibuat untuk pembelajaran sistem informasi berbasis web menggunakan PHP Native.

---

✨ **YOOOW STORE - Toko Online Terpercaya**
