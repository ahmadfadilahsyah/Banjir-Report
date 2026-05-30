# 🌊 Banjir Report

Sistem Pelaporan Banjir Berbasis Web Menggunakan PHP Native dan MySQL.

## 📌 Deskripsi

Banjir Report adalah aplikasi web yang memungkinkan masyarakat melaporkan kejadian banjir secara online. Laporan yang dikirimkan akan diterima oleh admin untuk diverifikasi dan ditindaklanjuti.

Sistem ini dibuat untuk membantu proses pelaporan bencana menjadi lebih cepat, terstruktur, dan mudah dipantau.

---

## ✨ Fitur Utama

### Masyarakat

* Mengirim laporan banjir
* Mengunggah foto kondisi banjir
* Melihat status laporan
* Memantau perkembangan penanganan

### Admin

* Login Admin
* Dashboard Monitoring Laporan
* Mengubah status laporan
* Melihat detail laporan
* Grafik statistik laporan
* Logout Sistem

---

## 📊 Status Laporan

Laporan dapat memiliki status:

* Diterima
* Ditindaklanjuti
* Dikerjakan
* Selesai

---

## 🛠️ Teknologi

* PHP Native
* MySQL
* Bootstrap 5
* Bootstrap Icons
* Chart.js
* HTML5
* CSS3
* JavaScript

---

## 📂 Struktur Project

```text
banjir_report/
│
├── admin/
│   ├── dashboard_admin.php
│   ├── grafik_admin.php
│   ├── login_admin.php
│   └── logout.php
│
├── uploads/
│
├── cek_status.php
├── grafik.php
├── index.php
├── koneksi.php
├── proses_laporan.php
├── pw_set.php
└── update_status.php
```

---

## 🚀 Instalasi

### Clone Repository

```bash
git clone https://github.com/ahmadfadilahsyah/Banjir-Report.git
```

### Pindahkan ke XAMPP

Simpan project pada:

```text
C:\xampp\htdocs\
```

### Buat Database

```sql
CREATE DATABASE banjir_report;
```

### Import Database

Import file database melalui phpMyAdmin.

### Konfigurasi Database

Edit file:

```php
koneksi.php
```

Sesuaikan konfigurasi:

```php
$host = "localhost";
$user = "root";
$password = "";
$database = "banjir_report";
```

### Jalankan

Aktifkan:

* Apache
* MySQL

Lalu buka:

```text
http://localhost/banjir_report
```

---

## 📈 Alur Sistem

1. Masyarakat mengirim laporan banjir.
2. Data tersimpan ke database.
3. Admin melakukan verifikasi.
4. Status laporan diperbarui.
5. Masyarakat dapat memantau perkembangan laporan.

---

## 👨‍💻 Pengembang

Ahmad Fadilah Syah

Mahasiswa Informatika

GitHub:
https://github.com/ahmadfadilahsyah

---

## 📄 Lisensi

Project ini dibuat untuk kebutuhan pembelajaran dan pengembangan sistem informasi kebencanaan.
